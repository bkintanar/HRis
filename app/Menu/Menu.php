<?php

namespace HRis\Menu;

class Menu extends Breadcrumb
{
    const MAIN_MENU_LEVEL = 0;

    /**
     * Menu Model
     * @var Eloquent
     */
    protected $model;

    /**
     * Inner menu HTML string builder
     * @var callable
     */
    protected $inner_callable;

    /**
     * Outer menu HTML string builder
     * @var callable
     */
    protected $outer_callable;

    /**
     * Callable function for has access
     * @var callable
     */
    protected $has_access_callable;

    /**
     * Array of callable
     * @var array
     */
    protected $callables;

    /**
     * Menu lists that you want to only show
     * @var array
     */
    protected $lists;

    /**
     * Callback function for menu mapping
     * @var callable
     */
    protected $menu_map;

    /**
     * Menu constructor
     * @param Eloquent $model
     * @author Harlequin Doyon
     */
    public function __construct($model)
    {
        parent::__construct();
        $this->model = $model;
        $this->init();
    }

    /**
     * Initialize variables
     * @return this
     * @author Harlequin Doyon
     */
    private function init()
    {
        $this->callables = [];

        return $this;
    }

    /**
     * Inner menu HTML string builder
     * @param  callable $callback
     * @return this
     * @author Harlequin Doyon
     */
    public function inner(callable $callback)
    {
        $this->inner_callable = $callback;

        return $this;
    }

    /**
     * Outer menu HTML string builder
     * @param  callable $callback
     * @return this
     * @author Harlequin Doyon
     */
    public function outer(callable $callback)
    {
        $this->outer_callable = $callback;

        return $this;
    }

    /**
     * Add callable to the array to build a nested menu level
     * @return this
     * @author Harlequin Doyon
     */
    public function addLevel()
    {
        $this->callables[] = [
            'inner' => $this->inner_callable,
            'outer' => $this->outer_callable,
        ];

        return $this;
    }

    public function setLists($lists)
    {
        $this->lists = $lists;

        return $this;
    }

    public function getLists()
    {
        if (isset($this->lists) && ! empty($this->lists)) {
            return $this->lists;
        }

        return $this->model->lists('parent_id', 'id');
    }

    /**
     * Generate menu
     * @return string
     * @author Harlequin Doyon
     */
    public function make()
    {
        $output = '';

        $this->menu_tree = $this->addLevel()->parseMenuTree($this->getLists());
        $inner = $this->outputMenuTree($this->menu_tree, self::MAIN_MENU_LEVEL);
        $callback = $this->getCallback(0);

        $output .= call_user_func($callback['outer'], $inner);

        return $output;
    }

    public function menu_map(callable $callback)
    {
        $this->menu_map = $callback;

        return $this;
    }

    /**
     * Generate nested or non-nested menu HTML string
     * @param  array $tree
     * @param  integer $index menu level
     * @return string
     * @author Harlequin Doyon
     */
    public function outputMenuTree($tree, $index)
    {
        $output = '';
        $callback = $this->getCallback($index);

        if (!is_null($tree) && count($tree) > 0) {
            foreach ($tree as $menu_id => $inner_menu) {
                $menu = $this->model->find($menu_id);
                $is_nested = $this->model->whereParentId($menu_id)->count() ? true : false;

                if ($this->menu_map) {
                    $new_menu = call_user_func($this->menu_map, $menu);
                } else {
                    $new_menu = $menu;
                }

                $inner = call_user_func(
                    $callback['inner'],                             // Params
                                                                    // ------------
                    $new_menu,                                      // $menu
                    $this->outputMenuTree($inner_menu, $index + 1), // $body
                    $this->isActive($new_menu->href),               // $is_active
                    $is_nested,                                     // $is_nested
                    $this->hasAccess($menu)                         // $has_access
                );

                if ($index > 0) {
                    $output .= call_user_func($callback['outer'], $inner);
                } else {
                    $output .= $inner;
                }
            }
        }

        return $output;
    }

    /**
     * Parse the menu to its correct branches and levels
     * @param  array $tree 
     * @param  array $root
     * @return array
     * @author Harlequin Doyon
     */
    public function parseMenuTree($tree, $root = null)
    {
        $return = [];

        foreach ($tree as $child => $parent) {
            if ($parent == $root) {
                unset($tree[$child]);
                $return[$child] = $this->parseMenuTree($tree, $child);
            }
        }

        return empty($return) ? null : $return;
    }

    /**
     * Default method to check if user has the access to that certain menu
     * Just override this method to make your custom permission
     * @param  Eloquent  $menu
     * @return boolean   default to true
     * @author Harlequin Doyon
     */
    public function hasAccess($menu)
    {
        if (isset($this->has_access_callable) && !empty($this->has_access_callable)) {
            return call_user_func($this->has_access_callable, $menu);    
        }
        
        return true;
    }

    /**
     * Set the has_access variable by method chaining
     * @param callable $callback
     * @author Harlequin Doyon
     */
    public function setHasAccess(callable $callback)
    {
        $this->has_access_callable = $callback;
        
        return $this;
    }

    /**
     * Get the inner and outer callback for that menu level
     * @param  integer $index
     * @return array   ['inner' => callback, 'outer' => callback]
     * @author Harlequin Doyon
     */
    private function getCallback($index)
    {
        $callback = null;

        if (isset($this->callables[$index])) {
            $callback = $this->callables[$index];
        } else {
            // Repeat the last set callable function
            if (count($this->callables)) {
                $callback = $this->callables[count($this->callables) - 1];
            }
        }

        return $callback;
    }
}
