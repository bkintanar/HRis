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
 * Class Dependent
 * @package HRis\Eloquent
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
     * Additional fields to treat as Carbon instances.
     *
     * @var array
     */
    protected $dates = ['birth_date'];

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
        'birth_date'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dependents';

    /**
     * Casts birth_date attribute to Carbon
     *
     * @param $birth_date
     * @author Bertrand Kintanar
     */
    public function setBirthDateAttribute($birth_date)
    {
        $this->attributes['birth_date'] = Carbon::parse($birth_date) ? : null;
    }
}
