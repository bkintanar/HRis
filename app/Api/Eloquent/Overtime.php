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

class Overtime extends Model
{
    protected $table = 'overtime';

    protected $fillable = [
        'employee_id',
        'timelog_id',
        'status_id',
        'requested_in',
        'requested_hours',
        'follow_actual',
    ];

    protected $dates = ['requested_in'];
}
