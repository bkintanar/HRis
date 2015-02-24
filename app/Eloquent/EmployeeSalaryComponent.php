<?php namespace HRis\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeSalaryComponent
 * @package HRis
 */
class EmployeeSalaryComponent extends Model {

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $dates = ['effective_date'];

    /**
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function salaryComponent()
    {
        return $this->hasOne('HRis\Eloquent\SalaryComponent', 'id', 'component_id');
    }

    /**
     * @param $value
     */
    public function setEffectiveDateAttribute($value)
    {
        $this->attributes['effective_date'] = Carbon::parse($value) ? : null;
    }

    /**
     * @return array
     */
    function getCurrentComponentValue($employee_id, $component_id)
    {
        return $this->whereEmployeeId($employee_id)
            ->whereComponentId($component_id)
            ->orderBy('effective_date', 'desc')
            ->first();
    }

}
