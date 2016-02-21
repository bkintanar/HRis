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
 * Class EmergencyContact.
 *
 * @SWG\Definition(definition="EmergencyContact", required={"id", "employee_id"})
 * @SWG\Property(property="id", type="integer", format="int64", default=1, description="Unique identifier for the emergency contact")
 * @SWG\Property(property="employee_id", type="integer", format="int64", default=1, description="ID of the employee")
 * @SWG\Property(property="first_name", type="string", default="Noemi", description="First name of the employee's emergency contact")
 * @SWG\Property(property="middle_name", type="string", default="Antipolo", description="Middle name of the employee's emergency contact")
 * @SWG\Property(property="last_name", type="string", default="Kintanar", description="Last name of the employee's emergency contact")
 * @SWG\Property(property="relationship_id", type="integer", format="int64", default=5, description="Relationship ID of the employee's emergency contact")
 * @SWG\Property(property="home_phone", type="string", default="032 520 2160", description="Home phone of the employee's emergency contact")
 * @SWG\Property(property="mobile_phone", type="string", default="0919 846 0201", description="Mobile phone of the employee's emergency contact")
 */
class EmergencyContact extends Model
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
        'home_phone',
        'mobile_phone',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'emergency_contacts';

    /**
     * An emergency contact object has one relationship.
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
     * An emergency contact object belongs to employee.
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
