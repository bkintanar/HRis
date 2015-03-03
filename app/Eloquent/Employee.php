<?php namespace HRis\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Employee
 * @package HRis
 */
class Employee extends Model {

    use HasPlaceholder;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $dates = ['birth_date', 'joined_date', 'probation_end_date', 'permanency_date', 'resign_date'];

    /**
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
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'employees';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function city()
    {
        return $this->hasOne('HRis\Eloquent\City', 'id', 'address_city_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function country()
    {
        return $this->hasOne('HRis\Eloquent\Country', 'id', 'address_country_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function department()
    {
        return $this->hasOne('HRis\Eloquent\Department', 'id', 'department_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dependents()
    {
        return $this->hasMany('HRis\Eloquent\Dependent', 'employee_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function educations()
    {
        return $this->hasMany('HRis\Eloquent\Education');
    }

    /**
     * @return mixed
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function employmentStatus()
    {
        return $this->hasOne('HRis\Eloquent\EmploymentStatus', 'id', 'employment_status_id');
    }

    /**
     * @param $employee_id
     * @param $user_id
     * @return mixed
     */
    public function getEmployeeById($employee_id, $user_id)
    {
        if ($employee_id)
        {
            return self::whereEmployeeId($employee_id)->with('user', 'country', 'province', 'city', 'employmentStatus', 'jobHistories', 'dependents', 'employeeWorkShift')->first();
        }

        return self::whereUserId($user_id)->with('user', 'country', 'province', 'city', 'employmentStatus', 'jobHistories', 'dependents', 'employeeWorkShift')->first();
    }

    /**
     * @param $employee_id
     * @param $user_id
     * @return mixed
     */
    public function getEmployeeSalarydetails($employee_id, $user_id)
    {
        if ($employee_id)
        {
            return self::whereEmployeeId($employee_id)->with('employeeSalaryComponent', 'dependents')->first();
        }

        return self::whereEmployeeId($user_id)->with('employeeSalaryComponent', 'dependents')->first();
    }

    /**
     * @param $start_date
     * @return array
     */
    public function getTimeLog($start_date)
    {
        $work_shift = $this->employeeWorkShift()->first();

        $wstp = $work_shift->getWorkShiftRange($start_date);
        $time_in = $this->timelogs()->whereSwipeDate($wstp['from_datetime']->toDateString())->where('swipe_time', '>=', $wstp['from_datetime']->toTimeString())->first();
        $time_out = $this->timelogs()->whereSwipeDate($wstp['to_datetime']->toDateString())->where('swipe_time', '<=', $wstp['to_datetime']->toTimeString())->orderBy('id', 'desc')->first();

        // If employee logs out more than one hour after the work shift schedule check for extended time
        if ($time_out == null && $time_in != null)
        {
            $time_out = $this->timelogs()->where('swipe_datetime', '<=', $wstp['to_datetime']->addHours(4)->toDateTimeString())->orderBy('id', 'desc')->first();

            if ($time_out != null and $wstp['from_datetime']->addHours(24)->toDateTimeString() < $time_out->swipe_datetime)
            {
                $time_out = null;
            }

            if ($time_in->id == $time_out->id)
            {
                $time_out = null;
            }
        }

        // Checks for failure to Login or Logout
        if ($time_out && $time_in)
        {
            if ($time_out->swipe_time == $time_in->swipe_time)
            {
                if ($time_out->swipe_datetime >= $wstp['to_datetime']->subHour(1)->toDateTimeString() and $time_out->swipe_datetime <= $wstp['to_datetime']->addHours(4)->toDateTimeString())
                {
                    $time_in = null;
                }
                else
                {
                    $time_out = null;
                }
            }
        }

        return [
            'in_time'  => $time_in ? $time_in->swipe_time : null,
            'out_time' => $time_out ? $time_out->swipe_time : null
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function employeeWorkShift()
    {
        return $this->hasMany('HRis\Eloquent\EmployeeWorkShift', 'employee_id', 'id')
            ->orderBy('effective_date', 'desc')
            ->orderBy('id', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function timelogs()
    {
        return $this->hasMany('HRis\Eloquent\TimeLog', 'face_id', 'face_id');
    }

    /**
     * @return mixed
     */
    public function jobHistory()
    {
        return $this->jobHistories()->with('workShift')->orderBy('job_histories.id', 'desc')->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobHistories()
    {
        return $this->hasMany('HRis\Eloquent\JobHistory');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function jobTitle()
    {
        return $this->hasOne('HRis\Eloquent\JobTitle', 'id', 'job_title_id');
    }

    /**
     * @return mixed
     */
    public function orderedJobHistories()
    {
        return $this->jobHistories()->with('jobTitle', 'department', 'employmentStatus', 'workShift', 'location')->orderBy('job_histories.id', 'desc')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function province()
    {
        return $this->hasOne('HRis\Eloquent\Province', 'id', 'address_province_id');
    }

    /**
     * @param $value
     */
    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = $value ? : null;
    }

    /**
     * @param $value
     */
    public function setEmployeeIdAttribute($value)
    {
        $this->attributes['employee_id'] = $value ? : null;
    }

    /**
     * @param $value
     */
    public function setFaceIdAttribute($value)
    {
        $this->attributes['face_id'] = $value ? : null;
    }

    /**
     * @param $value
     */
    public function setHdmfPagibigAttribute($value)
    {
        $this->attributes['hdmf_pagibig'] = $value ? : null;
    }

    /**
     * @param $value
     */
    public function setJoinedDateAttribute($value)
    {
        $this->attributes['joined_date'] = Carbon::parse($value) ? : null;
    }

    /**
     * @param $value
     */
    public function setMaritalStatusIdAttribute($value)
    {
        $this->attributes['marital_status_id'] = $value ? : null;
    }

    /**
     * @param $value
     */
    public function setPermanencyDateAttribute($value)
    {
        $this->attributes['permanency_date'] = Carbon::parse($value) ? : null;
    }

    /**
     * @param $value
     */
    public function setPhilHealthAttribute($value)
    {
        $this->attributes['philhealth'] = $value ? : null;
    }

    /**
     * @param $value
     */
    public function setProbationEndDateAttribute($value)
    {
        $this->attributes['probation_end_date'] = Carbon::parse($value) ? : null;
    }

    /**
     * @param $value
     */
    public function setResignDateAttribute($value)
    {
        $this->attributes['resign_date'] = Carbon::parse($value) ? : null;
    }

    /**
     * @param $value
     */
    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = $value ? : null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function skills()
    {
        return $this->belongsToMany('HRis\Eloquent\Skill');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('HRis\Eloquent\User', 'id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workExperiences()
    {
        return $this->hasMany('HRis\Eloquent\WorkExperience');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function workShift()
    {
        return $this->hasOne('HRis\Eloquent\WorkShift', 'id', 'work_shift_id');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . ($this->middle_name ? $this->middle_name . ' ' : '') . $this->last_name . ($this->suffix_name ? ' ' . $this->suffix_name : '');
    }

}
