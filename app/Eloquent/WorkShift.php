<?php namespace HRis\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkShift
 * @package HRis
 */
class WorkShift extends Model {

    use HasPlaceholder;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $dates = ['from_date', 'to_date'];

    /**
     * @var array
     */
    protected $fillable = ['name', 'from_date', 'to_date', 'duration'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'work_shifts';

    /**
     * @param $value
     */
    public function setFromTimeAttribute($value)
    {
        $this->attributes['from_time'] = Carbon::parse($value) ? : null;
    }

    /**
     * @param $value
     */
    public function setToTimeAttribute($value)
    {
        $this->attributes['to_time'] = Carbon::parse($value) ? : null;
    }

    public function getTimeLogSpan($start_date)
    {
        // TODO: Add these to config
        $from_datetime = Carbon::parse($start_date . ' ' . $this->from_time)->subHour(1);
        $to_datetime = Carbon::parse($from_datetime)->addHours(11)->subSecond(1);

        return ['from_datetime' => $from_datetime, 'to_datetime' => $to_datetime];
    }

}
