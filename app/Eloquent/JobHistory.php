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
 * Class JobHistory
 * @package HRis\Eloquent
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
        'employee_id',
        'job_title_id',
        'employment_status_id',
        'department_id',
        'effective_date',
        'location_id',
        'comments'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'job_histories';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * @author Bertrand Kintanar
     */
    public function department()
    {
        return $this->hasOne('HRis\Eloquent\Department', 'id', 'department_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * @author Bertrand Kintanar
     */
    public function employmentStatus()
    {
        return $this->hasOne('HRis\Eloquent\EmploymentStatus', 'id', 'employment_status_id');
    }

    /**
     * @param null $fillables
     * @param $employee_id
     * @return null
     * @author Bertrand Kintanar
     */
    public function getCurrentEmployeeJob($fillables = null, $employee_id)
    {
        $job = $this->whereEmployeeId($employee_id)
            ->orderBy('effective_date', 'desc')
            ->orderBy('id', 'desc')
            ->first($fillables);

        return $job ? $job->toArray() : null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * @author Bertrand Kintanar
     */
    public function jobTitle()
    {
        return $this->hasOne('HRis\Eloquent\JobTitle', 'id', 'job_title_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * @author Bertrand Kintanar
     */
    public function location()
    {
        return $this->hasOne('HRis\Eloquent\Location', 'id', 'location_id');
    }

    /**
     * @param $effective_date
     * @author Bertrand Kintanar
     */
    public function setEffectiveDateAttribute($effective_date)
    {
        $this->attributes['effective_date'] = Carbon::parse($effective_date) ? : null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * @author Bertrand Kintanar
     */
    public function workShift()
    {
        return $this->hasOne('HRis\Eloquent\WorkShift', 'id', 'work_shift_id');
    }
}
