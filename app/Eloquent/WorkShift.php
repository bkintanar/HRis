<?php namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkShift
 * @package HRis
 */
class WorkShift extends Model {

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'work_shifts';

    /**
     * @var array
     */
    protected $fillable = ['name', 'from_date', 'to_date', 'duration'];

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

}
