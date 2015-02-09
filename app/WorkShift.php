<?php namespace HRis;

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
}
