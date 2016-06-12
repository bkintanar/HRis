<?php

/*
 * This file is part of the HRis Software package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @version    alpha
 *
 * @author     Bertrand Kintanar <bertrand.kintanar@gmail.com>
 * @license    BSD License (3-clause)
 * @copyright  (c) 2014-2016, b8 Studios, Ltd
 *
 * @link       http://github.com/HB-Co/HRis
 */

namespace HRis\Api\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class JobHistory.
 */
class JobHistory extends Model
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
        'job_title_id',
        'employment_status_id',
        'department_id',
        'effective_date',
        'location_id',
        'comments',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'job_histories';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'department_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function employmentStatus()
    {
        return $this->hasOne(EmploymentStatus::class, 'id', 'employment_status_id');
    }

    /**
     * @param null $fillables
     * @param      $employee_id
     *
     * @return null
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function getCurrentEmployeeJob($fillables, $employee_id)
    {
        $job = $this->whereEmployeeId($employee_id)
            ->orderBy('effective_date', 'desc')
            ->orderBy('id', 'desc')
            ->first($fillables);

        return $job ? $job->toArray() : null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function jobTitle()
    {
        return $this->hasOne(JobTitle::class, 'id', 'job_title_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function location()
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function workShift()
    {
        return $this->hasOne(WorkShift::class, 'id', 'work_shift_id');
    }
}
