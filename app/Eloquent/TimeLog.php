<?php namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TimeLog
 * @package HRis
 */
class TimeLog extends Model {

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['face_id', 'swipe_date', 'swipe_time'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'time_log';

}
