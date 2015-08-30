<?php

namespace HRis\Menu;

use HRis\Eloquent\Navlink;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class HRisSidebar extends BaseMenu
{
    /**
     * HRisSidebar constructor
     * @author Harlequin Doyon
     */
    public function __construct()
    {
        parent::__construct();
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
}
