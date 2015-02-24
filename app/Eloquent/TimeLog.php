<?php namespace HRis\Eloquent;

use Carbon\Carbon;
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
    protected $fillable = ['face_id', 'swipe_date', 'swipe_time', 'swipe_datetime'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'time_log';

    public function getSwipeDatetimeAttribute($value)
    {
        $this->attributes['swipe_datetime'] = Carbon::parse($this->swipe_date . ' ' . $this->swipe_time);
    }

    public function employee()
    {
        return $this->belongsTo('HRis\Eloquent\Employee', 'face_id', 'face_id');
    }

}
