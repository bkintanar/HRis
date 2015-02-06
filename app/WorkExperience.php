<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkExperience
 * @package HRis
 */
class WorkExperience extends Model {

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo('HRis\Employee', 'id', 'employee_id');
    }

}
