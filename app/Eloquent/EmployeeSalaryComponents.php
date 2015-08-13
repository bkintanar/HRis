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

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeSalaryComponent
 * @package HRis\Eloquent
 */
class EmployeeSalaryComponent extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Additional fields to treat as Carbon instances.
     *
     * @var array
     */
    protected $dates = ['effective_date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'component_id',
        'value',
        'employee_id',
        'effective_date'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'employee_salary_components';

    /**
     * @param $employee_id
     * @param $component_id
     * @return mixed
     * @author Jim Callanta
     */
    public function getCurrentComponentValue($employee_id, $component_id)
    {
        return $this->whereEmployeeId($employee_id)
            ->whereComponentId($component_id)
            ->orderBy('effective_date', 'desc')
            ->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * @author Jim Callanta
     */
    public function salaryComponent()
    {
        return $this->hasOne('HRis\Eloquent\SalaryComponents', 'id', 'component_id');
    }

    /**
     * @param $effective_date
     * @author Jim Callanta
     */
    public function setEffectiveDateAttribute($effective_date)
    {
        $this->attributes['effective_date'] = Carbon::parse($effective_date) ? : null;
    }
}
