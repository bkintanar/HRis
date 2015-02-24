<?php namespace HRis\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Employee
 * @package HRis
 */
class Employee extends Model {

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
        return $this->hasMany('HRis\Eloquent\Dependent', 'employee_id', 'employee_id');
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
            return self::whereEmployeeId($employee_id)->with('user', 'country', 'province', 'city', 'employmentStatus', 'jobHistories', 'dependents')->first();
        }

        return self::whereUserId($user_id)->with('user', 'country', 'province', 'city', 'employmentStatus', 'jobHistories', 'dependents')->first();
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
        $work_shift = $this->jobHistory()->workShift()->first();

        $wstp = $work_shift->getTimeLogSpan($start_date);

        $time_in = $this->timelogs()->whereSwipeDate($wstp['from_datetime']->toDateString())->where('swipe_time', '>=', $wstp['from_datetime']->toTimeString())->first();
        $time_out = $this->timelogs()->whereSwipeDate($wstp['to_datetime']->toDateString())->where('swipe_time', '<=', $wstp['to_datetime']->toTimeString())->orderBy('id', 'desc')->first();

        return ['time_in' => $time_in ? $time_in->swipe_time : null, 'time_out' => $time_out  ? $time_out->swipe_time : null];
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function timelogs()
    {
        return $this->hasMany('HRis\Eloquent\TimeLog', 'face_id', 'face_id');
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

}
