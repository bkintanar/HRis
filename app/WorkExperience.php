<?php namespace HRis;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkExperience
 * @package HRis
 */
class WorkExperience extends Model {

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'work_experiences';

    /**
     * @var array
     */
    protected $fillable = ['employee_id', 'company', 'job_title', 'from_date', 'to_date', 'comment'];

    /**
     * @var array
     */
    protected $dates = ['from_date', 'to_date'];

    /**
     * @param $value
     */
    public function setToDateAttribute($value)
    {
        $this->attributes['to_date'] = Carbon::parse($value) ? : null;
    }

    /**
     * @param $value
     */
    public function setFromDateAttribute($value)
    {
        $this->attributes['from_date'] = Carbon::parse($value) ? : null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo('HRis\Employee', 'id', 'employee_id');
    }

}
