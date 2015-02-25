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

}
