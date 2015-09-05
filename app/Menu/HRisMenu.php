<?php

namespace HRis\Menu;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Eloquent\Navlink;
use Illuminate\Support\Facades\Request;

class HRisMenu extends BaseMenu
{
    /**
     * HRisMenu constructor.
     *
     * @author Harlequin Doyon
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Generates the sidebar menu HTML.
     *
     * @return string
     *
     * @author Harlequin Doyon
     */
    public function make()
    {
        $this->inner(function ($menu, $body, $is_active, $is_nested, $has_access) {
            if (!$has_access) {
                return '';
            }

            $output = '<li class="'.$this->stylesheetClasses($menu, $is_active).'">';
            $output .= '<a href="/'.$menu->href.'">';
            $output .= '<i class="fa '.$menu->icon.' m-right-a"></i>';
            $output .= $menu->name;
            $output .= '</a></li>';

            return $output;
        })
        ->outer(function ($body) {
            $output = '<div class="col-lg-12 top-nav-b"><div class="btn-group top-nav-li"><ul>';
            $output .= $body;
            $output .= '</ul></div></div>';

            return $output;
        });

        return parent::make();
    }

    /**
     * Generates the breadcrumb HTML.
     *
     * @return string
     *
     * @author Harlequin Doyon
     */
    public function breadcrumb()
    {
        $this->setInnerBreadcrumb(function ($breadcrumb) {
            $output = '<li>';
            $output .= '<a href="/'.$breadcrumb->href.'">';
            $output .= $breadcrumb->name;
            $output .= '</a>';
            $output .= '</li>';

            return $output;
        })
        ->setOuterBreadcrumb(function ($body) {
            $output = $body;

            return $output;
        });

        return parent::breadcrumb();
    }

    /**
     * Parent href of the menu.
     *
     * @param string $parent
     *
     * @return this
     *
     * @author Harlequin Doyon
     */
    public function parent($parent)
    {
        $lists = $this->model
            ->where('href', 'LIKE', $parent.'%')
            ->whereParentId(-1)
            ->lists('parent_id', 'id');

        foreach ($lists as $key => $item) {
            $lists[$key] = 0;
        }

        return $this->setLists($lists);
    }

    /**
     * Access profile menu.
     *
     * @return string
     *
     * @author Harlequin Doyon
     */
    public function profile()
    {
        $this->parent('profile');

        if ($this->request->is('pim*')) {
            $this->menu_map(function ($menu) {
                $link = 'pim/employee-list/'.$this->request->segment(3);
                $menu->href = str_replace('profile', $link, $menu->href);
                $menu->pim = $this->role(str_replace($link, 'pim', $menu->href));

                return $menu;
            });
        }

        return $this->make();
    }

    /**
     * Override the default method of the parent class.
     *
     * @param Navlink $menu
     *
     * @return bool
     *
     * @author Harlequin Doyon
     */
    public function hasAccess($menu)
    {
        $user = Sentinel::getUser();

        if ($user->hasAccess(isset($menu->pim) ? $menu->pim : $this->role($menu->href))) {
            return true;
        }

        return false;
    }
}
