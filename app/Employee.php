<?php namespace HRis;

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
        return $this->hasMany('HRis\JobHistory', 'employee_id', 'employee_id');
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
            return self::whereEmployeeId($employee_id)->with('user', 'country', 'province', 'city', 'employmentStatus', 'jobHistories')->first();
        }

        return self::whereUserId($user_id)->with('user', 'country', 'province', 'city', 'employmentStatus', 'jobHistories')->first();
    }
}
