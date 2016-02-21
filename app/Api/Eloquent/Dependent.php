<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Swagger\Annotations as SWG;

/**
 * Class Dependent.
 *
 * @SWG\Definition(definition="Dependent", required={"id", "employee_id", "relationship_id"})
 * @SWG\Property(property="id", type="integer", format="int64", default=1, description="Unique identifier for the dependent")
 * @SWG\Property(property="employee_id", type="integer", format="int64", default=1, description="ID of the employee")
 * @SWG\Property(property="first_name", type="string", default="Noemi", description="First name of the employee's dependent")
 * @SWG\Property(property="middle_name", type="string", default="Antipolo", description="Middle name of the employee's dependent")
 * @SWG\Property(property="last_name", type="string", default="Kintanar", description="Last name of the employee's dependent")
 * @SWG\Property(property="relationship_id", type="integer", format="int64", default=5, description="Relationship ID of the employee's dependent")
 * @SWG\Property(property="birth_date", type="string", default="2015-01-01", description="Birth date of the employee's dependent")
 */
class Dependent extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'first_name',
        'middle_name',
        'last_name',
        'relationship_id',
        'birth_date',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dependents';

    /**
     * A dependent object has one relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function relationship()
    {
        return $this->hasOne('HRis\Api\Eloquent\Relationship', 'id', 'relationship_id');
    }

    /**
     * A dependent object belongs to employee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function employee()
    {
        return $this->belongsTo('HRis\Api\Eloquent\Employee', 'employee_id', 'id');
    }
}
