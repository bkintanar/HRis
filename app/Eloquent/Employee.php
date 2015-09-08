<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Employee.
 */
class Employee extends Model
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
    protected $dates = ['birth_date', 'joined_date', 'probation_end_date', 'permanency_date', 'resign_date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'user_id',
        'face_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'birth_date',
        'social_security',
        'tax_identification',
        'philhealth',
        'hdmf_pagibig',
        'marital_status_id',
        'nationality_id',
        'address_1',
        'address_2',
        'address_city_id',
        'address_province_id',
        'address_country_id',
        'address_postal_code',
        'home_phone',
        'mobile_phone',
        'work_email',
        'other_email',
        'joined_date',
        'probation_end_date',
        'permanency_date',
        'resign_date',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'employees';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     *
     * @author Bertrand Kintanar
     */
    public function city()
    {
        return $this->hasOne('HRis\Eloquent\City', 'id', 'address_city_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     *
     * @author Bertrand Kintanar
     */
    public function country()
    {
        return $this->hasOne('HRis\Eloquent\Country', 'id', 'address_country_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @author Bertrand Kintanar
     */
    public function dependents()
    {
        return $this->hasMany('HRis\Eloquent\Dependent', 'employee_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @author Bertrand Kintanar
     */
    public function customFieldValues()
    {
        return $this->hasMany('HRis\Eloquent\CustomFieldValue', 'employee_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @author Bertrand Kintanar
     */
    public function educations()
    {
        return $this->hasMany('HRis\Eloquent\Education');
    }

    /**
     * @return mixed
     *
     * @author Jim Callanta
     */
    public function employeeSalaryComponent()
    {
        return $this->hasMany('HRis\Eloquent\EmployeeSalaryComponent', 'employee_id', 'id')
            ->with('salaryComponent')
            ->orderBy('id', 'desc')
            ->orderBy('effective_date', 'desc')
            ->take(4);
    }

    /**
     * @param $employee_id
     * @param $user_id
     *
     * @return mixed
     *
     * @author Bertrand Kintanar
     */
    public function getEmployeeById($employee_id, $user_id)
    {
        if ($employee_id) {
            return self::whereEmployeeId($employee_id)->with('user', 'country', 'province', 'city', 'jobHistories',
                'dependents', 'employeeWorkShift', 'customFieldValues')->first();
        }

        return self::whereUserId($user_id)->with('user', 'country', 'province', 'city', 'jobHistories', 'dependents',
            'employeeWorkShift', 'customFieldValues')->first();
    }

    /**
     * @param bool|true $paginate
     * @param string    $sort
     * @param string    $direction
     *
     * @return mixed
     *
     * @author Bertrand Kintanar
     */
    public function getEmployeeList($paginate = true, $sort = 'employees.id', $direction = 'asc')
    {
        $employees = $this->select('employees.id', 'employees.employee_id', 'employees.first_name',
            'employees.last_name', 'job_titles.name as job', 'employment_statuses.name as status',
            'employment_statuses.class');
        $employees->leftJoin(
            \DB::raw('(SELECT `employee_id`, `job_title_id`, `employment_status_id`, `effective_date` FROM `job_histories` AS `jh` WHERE `effective_date` = (SELECT MAX(`effective_date`) FROM `job_histories` AS `jh2` WHERE `jh`.`employee_id` = `jh2`.`employee_id`) group by `employee_id` ) AS `jh`'),
            'employees.id', '=', 'jh.employee_id');
        $employees->leftJoin('job_titles', 'jh.job_title_id', '=', 'job_titles.id');
        $employees->leftJoin('employment_statuses', 'jh.employment_status_id', '=', 'employment_statuses.id');
        $employees->orderBy($sort, $direction);

        if ($paginate) {
            return $employees->paginate(DATAS_PER_PAGE);
        }

        return $employees;
    }

    /**
     * @param $employee_id
     * @param $user_employee_id
     *
     * @return mixed
     *
     * @author Jim Callanta
     */
    public function getEmployeeSalaryDetails($employee_id, $user_employee_id)
    {
        if ($employee_id) {
            return self::whereEmployeeId($employee_id)->with('employeeSalaryComponent', 'dependents')->first();
        }

        return self::whereId($user_employee_id)->with('employeeSalaryComponent', 'dependents')->first();
    }

    /**
     * @return string
     *
     * @author Bertrand Kintanar
     */
    public function getFullNameAttribute()
    {
        return $this->first_name.' '.($this->middle_name ? $this->middle_name.' ' : '').$this->last_name.($this->suffix_name ? ' '.$this->suffix_name : '');
    }

    /**
     * @param $start_date
     *
     * @return array
     *
     * @author Bertrand Kintanar
     */
    public function getTimelog($start_date)
    {
        $work_shift = $this->employeeWorkShift()->first();

        $wstp = $work_shift->getWorkShiftRange($start_date);
        $time_in = $this->timelogs()->whereSwipeDate($wstp['from_datetime']->toDateString())->where('swipe_time', '>=',
            $wstp['from_datetime']->toTimeString())->first();
        $time_out = $this->timelogs()->whereSwipeDate($wstp['to_datetime']->toDateString())->where('swipe_time', '<=',
            $wstp['to_datetime']->toTimeString())->orderBy('id', 'desc')->first();

        // If employee logs out more than one hour after the work shift schedule check for extended time
        if ($time_out == null && $time_in != null) {
            $time_out = $this->timelogs()->where('swipe_datetime', '<=',
                $wstp['to_datetime']->addHours(4)->toDateTimeString())->orderBy('id', 'desc')->first();

            if ($time_out != null and $wstp['from_datetime']->addHours(24)->toDateTimeString() < $time_out->swipe_datetime) {
                $time_out = null;
            }

            if ($time_in->id == $time_out->id) {
                $time_out = null;
            }
        }

        // Checks for failure to Login or Logout
        if ($time_out && $time_in) {
            if ($time_out->swipe_time == $time_in->swipe_time) {
                if ($time_out->swipe_datetime >= $wstp['to_datetime']->subHour(1)->toDateTimeString() and $time_out->swipe_datetime <= $wstp['to_datetime']->addHours(4)->toDateTimeString()) {
                    $time_in = null;
                } else {
                    $time_out = null;
                }
            }
        }

        return [
            'in_time'  => $time_in ? $time_in->swipe_time : null,
            'out_time' => $time_out ? $time_out->swipe_time : null,
        ];
    }

    /**
     * @return mixed
     *
     * @author Bertrand Kintanar
     */
    public function employeeWorkShift()
    {
        return $this->hasMany('HRis\Eloquent\EmployeeWorkShift', 'employee_id', 'id')->with('workShift')
            ->orderBy('effective_date', 'desc')
            ->orderBy('id', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @author Bertrand Kintanar
     */
    public function timelogs()
    {
        return $this->hasMany('HRis\Eloquent\Timelog', 'face_id', 'face_id');
    }

    /**
     * @return mixed
     *
     * @author Bertrand Kintanar
     */
    public function jobHistory()
    {
        return $this->jobHistories()->with('workShift', 'jobTitle')->orderBy('job_histories.id', 'desc')->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @author Bertrand Kintanar
     */
    public function jobHistories()
    {
        return $this->hasMany('HRis\Eloquent\JobHistory');
    }

    /**
     * @return mixed
     *
     * @author Bertrand Kintanar
     */
    public function orderedJobHistories()
    {
        return $this->jobHistories()->with('jobTitle', 'department', 'workShift',
            'location')->orderBy('job_histories.id', 'desc')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     *
     * @author Bertrand Kintanar
     */
    public function province()
    {
        return $this->hasOne('HRis\Eloquent\Province', 'id', 'address_province_id');
    }

    /**
     * @param $birth_date
     *
     * @author Bertrand Kintanar
     */
    public function setBirthDateAttribute($birth_date)
    {
        $this->attributes['birth_date'] = Carbon::parse($birth_date) ?: null;
    }

    /**
     * @param $employee_id
     *
     * @author Bertrand Kintanar
     */
    public function setEmployeeIdAttribute($employee_id)
    {
        $this->attributes['employee_id'] = $employee_id ?: null;
    }

    /**
     * @param $face_id
     *
     * @author Bertrand Kintanar
     */
    public function setFaceIdAttribute($face_id)
    {
        $this->attributes['face_id'] = $face_id ?: null;
    }

    /**
     * @param $hdmf_pagibig
     *
     * @author Bertrand Kintanar
     */
    public function setHdmfPagibigAttribute($hdmf_pagibig)
    {
        $this->attributes['hdmf_pagibig'] = $hdmf_pagibig ?: null;
    }

    /**
     * @param $joined_date
     *
     * @author Bertrand Kintanar
     */
    public function setJoinedDateAttribute($joined_date)
    {
        $this->attributes['joined_date'] = Carbon::parse($joined_date) ?: null;
    }

    /**
     * @param $marital_status_id
     *
     * @author Bertrand Kintanar
     */
    public function setMaritalStatusIdAttribute($marital_status_id)
    {
        $this->attributes['marital_status_id'] = $marital_status_id ?: null;
    }

    /**
     * @param $permanency_date
     *
     * @author Bertrand Kintanar
     */
    public function setPermanencyDateAttribute($permanency_date)
    {
        $this->attributes['permanency_date'] = Carbon::parse($permanency_date) ?: null;
    }

    /**
     * @param $philhealth
     *
     * @author Bertrand Kintanar
     */
    public function setPhilHealthAttribute($philhealth)
    {
        $this->attributes['philhealth'] = $philhealth ?: null;
    }

    /**
     * @param $probation_end_date
     *
     * @author Bertrand Kintanar
     */
    public function setProbationEndDateAttribute($probation_end_date)
    {
        $this->attributes['probation_end_date'] = Carbon::parse($probation_end_date) ?: null;
    }

    /**
     * @param $resign_date
     *
     * @author Bertrand Kintanar
     */
    public function setResignDateAttribute($resign_date)
    {
        $this->attributes['resign_date'] = Carbon::parse($resign_date) ?: null;
    }

    /**
     * @param $user_id
     *
     * @author Bertrand Kintanar
     */
    public function setUserIdAttribute($user_id)
    {
        $this->attributes['user_id'] = $user_id ?: null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     * @author Bertrand Kintanar
     */
    public function skills()
    {
        return $this->belongsToMany('HRis\Eloquent\Skill');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     *
     * @author Bertrand Kintanar
     */
    public function user()
    {
        return $this->hasOne('HRis\Eloquent\User', 'id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @author Bertrand Kintanar
     */
    public function workExperiences()
    {
        return $this->hasMany('HRis\Eloquent\WorkExperience');
    }
}
