<?php namespace HRis;

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
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'employees';

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
     * @var array
     */
    protected $dates = ['birth_date', 'joined_date', 'probation_end_date', 'permanency_date', 'resign_date'];

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
    public function setPhilHealthAttribute($value)
    {
        $this->attributes['philhealth'] = $value ? : null;
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
    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = $value ? : null;
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
    public function setProbationEndDateAttribute($value)
    {
        $this->attributes['probation_end_date'] = Carbon::parse($value) ? : null;
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
    public function setResignDateAttribute($value)
    {
        $this->attributes['resign_date'] = Carbon::parse($value) ? : null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('HRis\User', 'id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function jobTitle()
    {
        return $this->hasOne('HRis\JobTitle', 'id', 'job_title_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function department()
    {
        return $this->hasOne('HRis\Department', 'id', 'department_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function employmentStatus()
    {
        return $this->hasOne('HRis\EmploymentStatus', 'id', 'employment_status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function country()
    {
        return $this->hasOne('HRis\Country', 'id', 'address_country_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function province()
    {
        return $this->hasOne('HRis\Province', 'id', 'address_province_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function city()
    {
        return $this->hasOne('HRis\City', 'id', 'address_city_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function workShift()
    {
        return $this->hasOne('HRis\WorkShift', 'id', 'work_shift_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workExperiences()
    {
        return $this->hasMany('HRis\WorkExperience');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function educations()
    {
        return $this->hasMany('HRis\Education');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function skills()
    {
        return $this->belongsToMany('HRis\Skill');
    }

    /**
     * @return mixed
     */
    public function jobHistory()
    {
        return $this->jobHistories()->orderBy('job_histories.id', 'desc')->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jobHistories()
    {
        return $this->hasMany('HRis\JobHistory');
    }

    /**
     * @return mixed
     */
    public function orderedJobHistories()
    {
        return $this->jobHistories()->with('jobTitle', 'department', 'employmentStatus', 'workShift', 'location')->orderBy('job_histories.id', 'desc')->get();
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dependents()
    {
        return $this->hasMany('HRis\Dependent', 'employee_id', 'employee_id');
    }

    /**
     * @return mixed
     */
    public function employeeSalaryComponents()
    {
        return $this->hasMany('HRis\EmployeeSalaryComponents', 'employee_id', 'employee_id')
            ->with('salaryComponent')
            ->orderBy('id', 'desc')
            ->orderBy('effective_date', 'desc')
            ->take(4);
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
            return self::whereEmployeeId($employee_id)->with('employeeSalaryComponents', 'dependents')->first();
        }

        return self::whereEmployeeId($user_id)->with('employeeSalaryComponents', 'dependents')->first();
    }

}
