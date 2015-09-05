<?php

namespace HRis\Menu;

use HRis\Eloquent\Navlink;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Request;

class BaseMenu extends Menu
{
    /**
     * Access the current request
     * @var Request
     */
    protected $request;

    /**
     * BaseMenu constructor
     * @author Harlequin Doyon
     */
    public function __construct()
    {
        $model = new Navlink();
        $this->request = Request::capture();

        parent::__construct($model);
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

        if ($user->hasAccess($this->role($menu->href))) {
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
    protected function slashToPeriod($href)
    {
        return str_replace('/', '.', $href);
    }

    /**
     * Get the role syntax for the given href
     * @param  string $href
     * @return string
     * @author Harlequin Doyon
     */
    protected function role($href)
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
    protected function stylesheetClasses($menu, $is_active)
    {
        $class = $is_active ? 'active' : '';
        $class .= starts_with($menu->href, 'pim') || starts_with($menu->href, 'admin') ? ' navy' : '';

        return $class;
    }
}
