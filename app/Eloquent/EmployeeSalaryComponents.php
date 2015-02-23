<?php namespace HRis\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeSalaryComponents
 * @package HRis
 */
class EmployeeSalaryComponents extends Model {

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'employee_salary_components';

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
     * @var array
     */
    protected $dates = ['effective_date'];

    /**
     * @param $value
     */
    public function setEffectiveDateAttribute($value)
    {
        $this->attributes['effective_date'] = Carbon::parse($value) ? : null;
    }

    public function salaryComponent()
    {
        return $this->hasOne('HRis\Eloquent\SalaryComponents', 'id', 'component_id');
    }

}
