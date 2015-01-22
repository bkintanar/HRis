<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'work_experiences';

    public $timestamps = false;

    public function employee()
    {
        return $this->belongsTo('HRis\Employee', 'id', 'employee_id');
    }

}
