<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

class Education extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'educations';

    public $timestamps = false;

    public function employee()
    {
        return $this->belongsTo('HRis\Employee', 'id', 'employee_id');
    }

}
