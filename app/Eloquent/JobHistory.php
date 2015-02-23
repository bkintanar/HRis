<?php namespace HRis\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class JobHistory
 * @package HRis
 */
class JobHistory extends Model {

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $dates = ['effective_date'];

    /**
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'job_title_id',
        'employment_status_id',
        'department_id',
        'effective_date',
        'location_id',
        'work_shift_id',
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
     */
    public function department()
    {
        return $this->hasOne('HRis\Eloquent\Department', 'id', 'department_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function employmentStatus()
    {
        return $this->hasOne('HRis\Eloquent\EmploymentStatus', 'id', 'employment_status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function jobTitle()
    {
        return $this->hasOne('HRis\Eloquent\JobTitle', 'id', 'job_title_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function location()
    {
        return $this->hasOne('HRis\Eloquent\Location', 'id', 'location_id');
    }

    /**
     * @param $value
     */
    public function setEffectiveDateAttribute($value)
    {
        $this->attributes['effective_date'] = Carbon::parse($value) ? : null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function workShift()
    {
        return $this->hasOne('HRis\Eloquent\WorkShift', 'id', 'work_shift_id');
    }
}
