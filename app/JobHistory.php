<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

class JobHistory extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'job_histories';

    public $timestamps = false;

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

    public function workShift()
    {
        return $this->hasOne('HRis\WorkShift', 'id', 'work_shift_id');
    }

    public function location()
    {
        return $this->hasOne('HRis\Location', 'id', 'location_id');
    }
}
