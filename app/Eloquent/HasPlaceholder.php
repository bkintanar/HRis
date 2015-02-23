<?php namespace HRis\Eloquent;

/**
 * Class HasPlaceholder
 * @package HRis\Eloquent
 */
trait HasPlaceholder {

    /**
     * @param $name
     * @param $id
     * @param $parent_id
     * @return mixed
     */
    static function listsWithPlaceholder($name, $id, $parent_id = null)
    {
        $default = [0 => '--- Select ---'];

        $model = parent::lists($name, $id);

        if ($parent_id > 0)
        {
            // Builder Object
            $model = parent::whereId($parent_id)->lists($name, $id);
        }

        $model = $default + $model;

        return $model;
    }
}
