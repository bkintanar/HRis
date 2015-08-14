<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Attendance.
 */
class Attendance extends Model
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
    protected $dates = ['work_date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['employee_id', 'work_date', 'in_time', 'out_time'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'attendance';
}
