<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'employees';

    public $timestamps = false;

    public function user()
    {
        return $this->hasOne('HRis\User', 'id', 'user_id');
    }

    public function jobTitle()
    {
        return $this->hasOne('HRis\JobTitle', 'id', 'job_title_id');
    }

    public function department()
    {
        return $this->hasOne('HRis\Department', 'id', 'department_id');
    }

    public function employmentStatus()
    {
        return $this->hasOne('HRis\EmploymentStatus', 'id', 'employment_status_id');
    }

    public function country()
    {
        return $this->hasOne('HRis\Country', 'id', 'address_country_id');
    }

    public function province()
    {
        return $this->hasOne('HRis\Province', 'id', 'address_province_id');
    }

    public function city()
    {
        return $this->hasOne('HRis\City', 'id', 'address_city_id');
    }

    public function workShift()
    {
        return $this->hasOne('HRis\WorkShift', 'id', 'work_shift_id');
    }

    public function workExperiences()
    {
        return $this->hasMany('HRis\WorkExperience');
    }

    public function educations()
    {
        return $this->hasMany('HRis\Education');
    }

    public function skills()
    {
        return $this->hasMany('HRis\Skill');
    }

    public function jobHistory()
    {
        return $this->jobHistories()->orderBy('job_histories.id', 'desc')->first();
    }

    public function jobHistories()
    {
        return $this->hasMany('HRis\JobHistory', 'employee_id', 'employee_id');
    }

    public function orderedJobHistories()
    {
        return $this->jobHistories()->orderBy('job_histories.id', 'desc')->get();
    }

    public function getEmployeeById($employee_id, $user_id)
    {
        if ($employee_id)
        {
            return self::whereEmployeeId($employee_id)->with('user', 'country', 'province', 'city', 'employmentStatus', 'jobHistories')->first();
        }

        return self::whereUserId($user_id)->with('user', 'country', 'province', 'city', 'employmentStatus', 'jobHistories')->first();
    }
}
