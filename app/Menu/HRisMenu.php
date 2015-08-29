<?php

namespace HRis\Menu;

use HRis\Eloquent\Navlink;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class HRisMenu extends Menu
{
    /**
     * HRisMenu constructor
     * @author Harlequin Doyon
     */
    public function __construct()
    {
        $model = new Navlink();
        parent::__construct($model);
    }

    /**
     * Generates the sidebar menu HTML
     * @return string
     * @author Harlequin Doyon
     */
    public function make()
    {
        $self = $this;

        $this->inner(function ($menu, $body, $is_active, $is_nested, $has_access) use($self) {
            if (! $has_access) return '';

            $output = '<li class="'.$self->stylesheetClasses($menu, $is_active).'">';
            $output .= '<a href="/'.$menu->href.'">';
            $output .= '<i class="fa '.$menu->icon.'"></i>';
            $output .= '<span class="nav-label">'.$menu->name.'</span>';
            $output .= $is_nested ? '<span class="fa arrow"></span>' : '';
            $output .= '</a>';
            $output .= $body;
            $output .= '</li>';

            return $output;
        })
        ->outer(function ($body) {
            return $body;
        })
        ->addLevel() // Second level menu
        ->outer(function ($body) {
            $output = '<ul class="nav nav-second-level">';
            $output .= $body;
            $output .= '</ul>';

            return $output;
        })
        ->addLevel() // Third level menu
        ->outer(function ($body) {
            $output = '<ul class="nav nav-third-level">';
            $output .= $body;
            $output .= '</ul>';

            return $output;
        });

        return parent::make();
    }

    /**
     * Generates the breadcrumb HTML
     * @return string
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
     * Override the default method of the parent class
     * @param  Navlink  $menu
     * @return boolean
     * @author Harlequin Doyon
     */
    public function hasAccess($menu)
    {
        $user = Sentinel::getUser();

        if($user->hasAccess($this->role($menu->href))) {
            return true;
        }

        return false;
    }

    /**
     * Change the forward slashes to dots.
     * @param  string $href 
     * @return string
     * @author Harlequin Doyon
     */
    private function slashToPeriod($href)
    {
        return str_replace('/', '.', $href);
    }

    /**
     * Get the role syntax for the given href
     * @param  string $href
     * @return string
     * @author Harlequin Doyon
     */
    private function role($href)
    {
        return $this->slashToPeriod($href).'.view';
    }

    /**
     * Get sidebar menu <li> stylesheet classes
     * @param  Navlink $menu
     * @param  boolean $is_active
     * @return string
     * @author Harlequin Doyon
     */
    private function stylesheetClasses($menu, $is_active)
    {
        $class = $is_active ? 'active' : '';
        $class .= starts_with($menu->href, 'pim') || starts_with($menu->href, 'admin') ? ' navy' : '';

        return $class;
    }
}
