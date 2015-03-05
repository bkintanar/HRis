<?php namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Attendance
 * @package HRis
 */
class Attendance extends Model {

    public $timestamps = false;
    protected $fillable = [
        'employee_id',
        'work_date',
        'in_time',
        'out_time'
    ];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'attendance';
}
