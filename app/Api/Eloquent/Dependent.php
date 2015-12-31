<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Dependent.
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