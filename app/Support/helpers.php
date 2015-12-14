<?php

if (!function_exists('permission')) {
    function permission($label, $only = [])
    {
        $permit = ['create', 'update', 'view', 'delete'];

        // If $only array is empty return all permission
        if (!count($only)) {
            $only = $permit;
        }

        $arr = [];

        foreach ($only as $action) {
            if (in_array($action, $permit)) {
                $arr[$label . '.' . $action] = true;
            }
        }

        return $arr;
    }
}
