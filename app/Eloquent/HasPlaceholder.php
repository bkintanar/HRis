<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 *
 */

namespace HRis\Eloquent;

/**
 * Class HasPlaceholder
 * @package HRis\Eloquent
 */
trait HasPlaceholder
{

    /**
     * This trait is needed if a model needs a placeholder.
     *
     * @param $name
     * @param $id
     * @param null $parent_id
     * @return array
     * @author Bertrand Kintanar
     */
    public static function listsWithPlaceholder($name, $id, $parent_id = null)
    {
        $default = [0 => '--- Select ---'];

        $model = parent::lists($name, $id)->all();

        if ($parent_id > 0) {
            // Builder Object
            $model = parent::whereId($parent_id)->lists($name, $id);
        }

        $model = $default + $model;

        return $model;
    }
}
