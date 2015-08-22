<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Eloquent;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;

/**
 * Class Navlink.
 */
class Navlink extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'navlinks';

    /**
     * @param $_link
     *
     * @return string
     *
     * @author Bertrand Kintanar
     */
    protected static function breadcrumb($_link)
    {
        $str = '';
        $subLinks = explode('/', $_link);
        $numSubLinks = count($subLinks);

        $idx = 0;
        $href = '/';
        foreach ($subLinks as $sublink) {
            $href .= $sublink;
            $exception = ['pim'];
            if (++$idx === $numSubLinks) {
                $str .= '<li class="active"><strong>'.ucwords(str_replace('-', ' ',
                        in_array($sublink, $exception) ? strtoupper($sublink) : $sublink)).'</strong></li>';
            } else {
                $employee_id_prefix = Config::get('company.employee_id_prefix');
                if (substr($sublink, 0, strlen($employee_id_prefix)) == $employee_id_prefix) {
                    $str .= '<li>'.'<a href="'.$href.'">'.ucwords(in_array($sublink,
                            $exception) ? strtoupper($sublink) : $sublink).'</a></li>';
                } else {
                    $str .= '<li>'.'<a href="'.$href.'">'.ucwords(str_replace('-', ' ',
                            in_array($sublink, $exception) ? strtoupper($sublink) : $sublink)).'</a></li>';
                }
            }

            $href .= '/';
        }

        return $str;
    }

    /**
     * @return string
     *
     * @author Bertrand Kintanar
     */
    protected static function generate()
    {
        $user = Sentinel::getUser();
        $result = '';

        $_parent_links = self::whereParentId(0)->get();

        foreach ($_parent_links as $_parent_link) {
            $href = str_replace('/', '.', $_parent_link->href);

            if ($user->hasAccess($href.'.view')) {
                $children = self::whereParentId($_parent_link->id)->get();

                $item = self::generateNavLinkItem($_parent_link, $children);

                $result .= $item;
            }
        }

        return $result;
    }

    /**
     * @param $link
     * @param $children
     *
     * @return string
     *
     * @author Bertrand Kintanar
     */
    protected static function generateNavLinkItem($link, $children)
    {
        $user = Sentinel::getUser();

        $special_link_ids = self::getSpecialNavLinkIds();

        $item = '<li';

        if (self::isURLActive($link->href)) {
            $item .= ' class="active">'.PHP_EOL;
        } else {
            $item .= '>'.PHP_EOL;
        }

        if (count($children) && !in_array($link->id, $special_link_ids)) {
            $item .= '<a href="#">'.PHP_EOL;
        } else {
            $item .= '<a href="/'.$link->href.'">'.PHP_EOL;
        }

        if ($link->icon != '') {
            $item .= '<i class="fa '.$link->icon.'"></i>'.PHP_EOL;
        }

        if ($link->parent_id == 0) {
            $item .= '<span class="nav-label">'.$link->name.'</span>'.PHP_EOL;
        } else {
            $item .= $link->name.PHP_EOL;
        }

        if (count($children) && !in_array($link->id, $special_link_ids)) {
            $item .= '<span class="fa arrow"></span>'.PHP_EOL;
        }

        $item .= '</a>'.PHP_EOL;

        if (count($children) && !in_array($link->id, $special_link_ids)) {
            if (self::whereId($children[0]->parent_id)->pluck('parent_id') > 0) {
                $item .= '<ul class="nav nav-third-level">'.PHP_EOL;
            } else {
                $item .= '<ul class="nav nav-second-level">'.PHP_EOL;
            }

            foreach ($children as $child) {
                $href = str_replace('/', '.', $child->href);

                if ($user->hasAccess($href.'.view')) {
                    $childrenOfChild = self::whereParentId($child->id)->get();
                    $item .= self::generateNavLinkItem($child, $childrenOfChild);
                }
            }

            $item .= '</ul>'.PHP_EOL;
        }

        $item .= '</li>'.PHP_EOL;

        return $item;
    }

    /**
     * These so called special navigation links are links in which are shown on the navigation
     * bar but we hide their child links.
     *
     * @return array
     *
     * @author Bertrand Kintanar
     */
    protected static function getSpecialNavLinkIds()
    {
        $special_nav_link_ids = self::select('id')->whereIn('name', ['Profile', 'Employee List'])->get(['id']);

        return array_flatten($special_nav_link_ids->toArray());
    }

    /**
     * Checks if the href is active.
     *
     * @param $href
     *
     * @return bool
     *
     * @author Bertrand Kintanar
     */
    protected static function isURLActive($href)
    {
        $request = Request::capture();

        if ($request->is($href.'*')) {
            return true;
        }

        return false;
    }

    /**
     * @param $id
     *
     * @return string
     *
     * @author Bertrand Kintanar
     */
    protected static function permissionTable($id)
    {
        $parents = self::whereParentId(0)->get();

        $result = '';
        foreach ($parents as $parent) {
            $result .= self::permissionTab($parent, $id);
        }

        return $result;
    }

    /**
     * @param $parent
     * @param $id
     *
     * @return string
     *
     * @author Bertrand Kintanar
     */
    protected static function permissionTab($parent, $id)
    {
        if ($parent->name == 'Profile') {
            $children = self::where('parent_id', '<', 0)->get();
        } else {
            $children = self::whereParentId($parent->id)->get();
        }

        $result = '<div id="tab-'.$parent->id.'" class="tab-pane'.($parent->id == PROFILE_IDS ? ' active' : '').'">';
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

        $result .= self::generatePermissions($children, $id);

        $result .= '</tbody>
                    </table>
                     <input class="btn btn-primary" type="submit" value="Save changes">
              </div>
            </div>';

        return $result;
    }

    /**
     * @param            $children
     * @param            $id
     * @param bool|false $indent
     * @param bool|false $double
     *
     * @return string
     *
     * @author Bertrand Kintanar
     */
    protected static function generatePermissions($children, $id, $indent = false, $double = false)
    {
        $result = '';
        foreach ($children as $child) {
            $result .= '<tr><td class="'.($indent == true ? 'indent' : '').($double == true ? '-double' : '').' ta-left">'.$child->name.'</td>';
            $result .= '<td></td>';

            $result .= self::generateCheckbox($child, $id, PERMISSION_VIEW);
            $result .= self::generateCheckbox($child, $id, PERMISSION_UPDATE);
            $result .= self::generateCheckbox($child, $id, PERMISSION_DELETE);
            $result .= self::generateCheckbox($child, $id, PERMISSION_CREATE);

            $result .= '</tr>';

            $childrenOfChild = self::whereParentId($child->id)->get();

            if (count($childrenOfChild)) {
                $result .= self::generatePermissions($childrenOfChild, $id, true, $indent == true ? true : false);
            }
        }

        return $result;
    }

    /**
     * @param $link
     * @param $id
     * @param $permission
     *
     * @return string
     *
     * @author Bertrand Kintanar
     */
    protected static function generateCheckbox($link, $id, $permission)
    {
        if ($link->permission & $permission) {
            switch ($permission) {
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

            $permission_name = str_replace('/', '.', $link->href).$mode;

            $user = User::whereId($id)->first();

            $checked = ($user->hasAccess($permission_name)) ? 'checked' : '';

            return '<td><input type="checkbox" class="i-checks" '.$checked.' name="permissions['.$permission_name.']"></td>';
        }

        return '<td></td>';
    }

    /**
     * @param bool|false $pim
     *
     * @return string
     *
     * @author Bertrand Kintanar
     */
    protected static function profileLinks($pim = false)
    {
        $user = Sentinel::getUser();

        $nav = '<div class="col-lg-12 top-nav-b"><div class="btn-group top-nav-li"><ul>';

        $navigations = self::where('parent_id', '<', 0)->get();

        foreach ($navigations as $navigation) {
            $format = self::formatHref($navigation, $pim);

            if (!$user->hasAccess($format['link'].'.view')) {
                continue;
            }

            $nav .= '<li';

            if (self::isURLActive($format['href'])) {
                $nav .= ' class="active">';
            } else {
                $nav .= '>';
            }

            $nav .= '<a href="/'.$format['href'].'">';
            $nav .= '<i class="fa '.$navigation->icon.' m-right-a"></i>';
            $nav .= $navigation->name;
            $nav .= '</a></li>';
        }

        $nav .= '</ul></div></div>';

        return $nav;
    }

    /**
     * @param $navigation
     * @param $pim
     *
     * @return array
     *
     * @author Bertrand Kintanar
     */
    protected static function formatHref($navigation, $pim)
    {
        if ($pim) {
            $href = str_replace('profile', 'pim/employee-list/'.Request::segment(3), $navigation->href);
            $permission = str_replace('pim/employee-list/'.Request::segment(3), 'pim', $href);
            $link = str_replace('/', '.', $permission);
        } else {
            $href = $navigation->href;
            $link = str_replace('/', '.', $href);
        }

        return ['href' => $href, 'link' => $link];
    }
}
