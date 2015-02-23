<?php namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeSkill
 * @package HRis
 */
class EmployeeSkill extends Model {

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'employee_skill';

}
