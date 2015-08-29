<?php

if (! function_exists('permission')) {
    
    function permission($label, $only = [])
    {
        $permitted = ['create', 'update', 'view', 'delete'];

        // If $only array is empty return all permitted
        if(! count($only)) {
            $only = $permitted;
        }

        $arr = [];

        foreach ($only as $action) {
            if(in_array($action, $permitted)) {
                $arr[$label.'.'.$action] = true; 
            }
        }

        return $arr;
    }
}