<?php namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TimeLog
 * @package HRis
 */
class TimeLog extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'time_log';

    protected $fillable = ['face_id', 'swipe_date', 'swipe_time'];

    public $timestamps = false;

}
