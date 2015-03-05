<?php namespace HRis\Eloquent;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

/**
 * Class Navlink
 * @package HRis
 */
class Navlink extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'navlinks';

    /**
     * @return string
     */
    public static function generate()
    {
        $sentry = Sentry::getUser();
        $result = '';

        $_parent_links = Navlink::whereParentId(0)->get();

        foreach ($_parent_links as $_parent_link)
        {
            $href = str_replace('/', '.', $_parent_link->href);

            if ($sentry->hasAccess($href . '.view'))
            {
                $children = Navlink::whereParentId($_parent_link->id)->get();

                $item = Navlink::generateNavLinkItem($_parent_link, $children);

                $result .= $item;
            }
        }

        return $result;
    }

    /**
     * @param $link
     * @param $children
     * @return string
     */
    public static function generateNavLinkItem($link, $children)
    {
        $sentry = Sentry::getUser();

        $item = '<li';

        if (Navlink::isURLActive($link->href))
        {
            $item .= ' class="active">' . PHP_EOL;
        }
        else
        {
            $item .= '>' . PHP_EOL;
        }

        // TODO: Don't hard code [2, 15]
        if (count($children) && ! in_array($link->id, [2, 15]))
        {
            $item .= '<a href="#">' . PHP_EOL;
        }
        else
        {
            $item .= '<a href="/' . $link->href . '">' . PHP_EOL;
        }

        if ($link->icon != '')
        {
            $item .= '<i class="fa ' . $link->icon . '"></i>' . PHP_EOL;
        }

        if ($link->parent_id == 0)
        {
            $item .= '<span class="nav-label">' . $link->name . '</span>' . PHP_EOL;
        }
        else
        {
            $item .= $link->name . PHP_EOL;
        }

        // TODO: Don't hard code [2, 15]
        if (count($children) && ! in_array($link->id, [2, 15]))
        {
            $item .= '<span class="fa arrow"></span>' . PHP_EOL;
        }


        $item .= '</a>' . PHP_EOL;

        // TODO: Don't hard code [2, 15]
        if (count($children) && ! in_array($link->id, [2, 15]))
        {
            if (Navlink::whereId($children[0]->parent_id)->pluck('parent_id') > 0)
            {
                $item .= '<ul class="nav nav-third-level">' . PHP_EOL;
            }
            else
            {
                $item .= '<ul class="nav nav-second-level">' . PHP_EOL;
            }

            foreach ($children as $child)
            {
                $href = str_replace('/', '.', $child->href);

                if ($sentry->hasAccess($href . '.view'))
                {
                    $childrenOfChild = Navlink::whereParentId($child->id)->get();
                    $item .= Navlink::generateNavLinkItem($child, $childrenOfChild);
                }
            }

            $item .= '</ul>' . PHP_EOL;
        }


        $item .= '</li>' . PHP_EOL;

        return $item;
    }

    /**
     * @param $href
     * @return bool
     */
    public static function isURLActive($href)
    {
        $request = Request::capture();

        if ($request->is('*' . $href . '*'))
        {
            return true;
        }

        return false;
    }

    /**
     * @param $_link
     * @return string
     */
    public static function breadcrumb($_link)
    {
        $str = '';


        $subLinks = explode('/', $_link);

        $numSubLinks = count($subLinks);
        $idx = 0;
        $href = '/';
        foreach ($subLinks as $sublink)
        {
            $href .= $sublink;
            $exception = ['pim'];
            if (++ $idx === $numSubLinks)
            {
                $str .= '<li class="active"><strong>' . ucwords(str_replace('-', ' ', in_array($sublink, $exception) ? strtoupper($sublink) : $sublink)) . '</strong></li>';
            }
            else
            {
                // TODO: Store 'GWO-' to config. Employee ID prefixes should not be hard coded.
                if (substr($sublink, 0, 4) == 'GWO-')
                {
                    $str .= '<li>' . '<a href="' . $href . '">' . ucwords(in_array($sublink, $exception) ? strtoupper($sublink) : $sublink) . '</a></li>';
                }
                else
                {
                    $str .= '<li>' . '<a href="' . $href . '">' . ucwords(str_replace('-', ' ', in_array($sublink, $exception) ? strtoupper($sublink) : $sublink)) . '</a></li>';
                }
            }

            $href .= '/';
        }

        return $str;
    }

    /**
     * @param bool $pim
     * @return string
     */
    public static function profileLinks($pim = false)
    {
        $sentry = Sentry::getUser();

        $nav = '<div class="col-lg-12 top-nav-b"><div class="btn-group top-nav-li"><ul>';

        $navigations = Navlink::whereParentId(- 1)->get();

        foreach ($navigations as $navigation)
        {
            $format = Navlink::formatHref($navigation, $pim);

            if ( ! $sentry->hasAccess($format['link'] . '.view')) continue;

            $nav .= '<li';

            if (Navlink::isURLActive($format['href']))
            {
                $nav .= ' class="active">';
            }
            else
            {
                $nav .= '>';
            }

            $nav .= '<a href="/' . $format['href'] . '">';
            $nav .= '<i class="fa ' . $navigation->icon . ' m-right-a"></i>';
            $nav .= $navigation->name;
            $nav .= '</a></li>';
        }

        $nav .= '</ul></div></div>';

//        $tidy = new \Tidy;
//
//        $tidy->parseString($nav, ['indent' => true, 'wrap' => 200], 'utf8');
////        $tidy->cleanRepair();
//        $tidy = str_replace(['<body>', '</body>'], '', $tidy->body()->value);

        return $nav;

    }

    /**
     * @param $navigation
     * @param $pim
     * @return array
     */
    private static function formatHref($navigation, $pim)
    {
        if ($pim)
        {
            $href = str_replace('profile', 'pim/employee-list/' . Request::segment(3), $navigation->href);
            $permission = str_replace('pim/employee-list/' . Request::segment(3), 'pim', $href);
            $link = str_replace('/', '.', $permission);
        }
        else
        {
            $href = $navigation->href;
            $link = str_replace('/', '.', $href);
        }

        return ['href' => $href, 'link' => $link];
    }

    /**
     * @param $id
     * @return string
     */
    public static function permissionTable($id)
    {
        $parents = Navlink::whereParentId(0)->get();

        $result = '';
        foreach ($parents as $parent)
        {
            $result .= Navlink::permissionTab($parent, $id);
        }

        return $result;
    }

    /**
     * @param $parent
     * @param $id
     * @return string
     */
    public static function permissionTab($parent, $id)
    {
        $children = Navlink::whereParentId($parent->id)->get();

        $result = '<div id="tab-' . $parent->id . '" class="tab-pane' . ($parent->id == PROFILE_IDS ? ' active' : '') . '">';
        $result .= '<div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="no-pdng ta-left">Permission Name</th>
                                    <th></th>
                                    <th class="no-pdng fix-width">View</th>
                                    <th class="no-pdng fix-width">Update</th>
                                    <th class="no-pdng fix-width">Delete</th>
                                    <th class="no-pdng fix-width">Create</th>
                                </tr>
                            </thead>
                            <tbody class="thin-table">';

        $result .= Navlink::generatePermissions($children, $id);

        $result .= '</tbody>
                    </table>
                     <input class="btn btn-primary" type="submit" value="Save changes">
              </div>
            </div>';

        return $result;
    }

    /**
     * @param $children
     * @param $id
     * @param bool $indent
     * @param bool $double
     * @return string
     */
    private static function generatePermissions($children, $id, $indent = false, $double = false)
    {
        $result = '';
        foreach ($children as $child)
        {
            $result .= '<tr><td class="' . ($indent == true ? 'indent' : '') . ($double == true ? '-double' : '') . ' ta-left">' . $child->name . '</td>';
            $result .= '<td></td>';

            $result .= Navlink::generateCheckbox($child, $id, PERMISSION_VIEW);
            $result .= Navlink::generateCheckbox($child, $id, PERMISSION_UPDATE);
            $result .= Navlink::generateCheckbox($child, $id, PERMISSION_DELETE);
            $result .= Navlink::generateCheckbox($child, $id, PERMISSION_CREATE);

            $result .= '</tr>';

            $childrenOfChild = Navlink::whereParentId($child->id)->get();

            if (count($childrenOfChild))
            {
                $result .= Navlink::generatePermissions($childrenOfChild, $id, true, $indent == true ? true : false);
            }
        }

        return $result;
    }

    /**
     * @param $link
     * @param $id
     * @param $permission
     * @return string
     */
    private static function generateCheckbox($link, $id, $permission)
    {
        if ($link->permission & $permission)
        {
            switch ($permission)
            {
                case PERMISSION_VIEW:
                    $mode = '.view';
                    break;
                case PERMISSION_UPDATE:
                    $mode = '.update';
                    break;
                case PERMISSION_DELETE:
                    $mode = '.delete';
                    break;
                case PERMISSION_CREATE:
                    $mode = '.create';
                    break;
            }

            $permission_name = str_replace('/', '.', $link->href) . $mode;

            $user = User::whereId($id)->first();

            $checked = ($user->hasAccess($permission_name)) ? 'checked' : '';

            return '<td><input type="checkbox" class="i-checks" ' . $checked . ' name="permissions[' . $permission_name . ']"></td>';
        }

        return '<td></td>';
    }

}
