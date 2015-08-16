<?php

namespace HRis\Menu;

class Menu extends Breadcrumb
{
    const MAIN_MENU_LEVEL = 0;

    protected $model;
    protected $inner_callable;
    protected $outer_callable;
    protected $callables;

    public function __construct($model)
    {
        parent::__construct();
        $this->model = $model;
        $this->init();
    }  

    private function init()
    {
        $this->callables = [];
    }

    public function isNested()
    {
        $array = $model->parseMenuTree(
            $this->model->lists('parent_id', 'id')
        );
        
        return (count($array) != count($array, 1));
    }

    public function inner(callable $callback)
    {
        $this->inner_callable = $callback;

        return $this;
    }

    public function outer(callable $callback)
    {
        $this->outer_callable = $callback;

        return $this;
    }

    public function addLevel()
    {
        $this->callables[] = [
            'inner' => $this->inner_callable,
            'outer' => $this->outer_callable,
        ];

        return $this;
    }

    public function make()
    {
        $output = '';

        $this->menu_tree = $this->addLevel()->parseMenuTree(
            $this->model->lists('parent_id', 'id')
        );

        $output .= $this->outputMenuTree($this->menu_tree, self::MAIN_MENU_LEVEL);

        return $output;
    }

    public function outputMenuTree($tree, $index)
    {
        $output = '';
        $callback = $this->getCallback($index);

        if (!is_null($tree) && count($tree) > 0) {
            foreach($tree as $menu_id => $inner_menu) {
                $menu = $this->model->find($menu_id);
                $is_nested = $this->model->whereParentId($menu_id)->count() ? true : false;

                $inner = call_user_func(
                    $callback['inner'],                             // Params
                                                                    // ------------
                    $menu,                                          // $menu
                    $this->outputMenuTree($inner_menu, $index + 1), // $body
                    $this->isActive($menu->href),                   // $is_active
                    $is_nested                                      // $is_nested
                );

                $output .= call_user_func($callback['outer'], $inner);
            }
        }

        return $output;
    }

    public function parseMenuTree($tree, $root = null)
    {
        $return = [];

        foreach ($tree as $child => $parent) {
            if($parent == $root) {
                unset($tree[$child]);
                $return[$child] = $this->parseMenuTree($tree, $child);
            }
        }

        return empty($return) ? null : $return;
    }

    private function getCallback($index)
    {
        $callback = null;

        if (isset($this->callables[$index])) {
            $callback = $this->callables[$index];
        } else {
            // Repeat the last set callable function
            if(count($this->callables)) {
                $callback = $this->callables[count($this->callables)-1];
            }
        }

        return $callback;
    }
}
