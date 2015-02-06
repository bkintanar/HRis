<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

class EmployeeSalaryComponents extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'employee_salary_components';

    public $timestamps = false;

    public function salaryComponent()
    {
        return $this->belongsToMany('HRis\SalaryComponents', 'id', 'component_id');
    }

}
