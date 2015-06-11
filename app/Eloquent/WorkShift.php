<?php

namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkShift
 * @package HRis\Eloquent
 */
class WorkShift extends Model
{

    use HasPlaceholder;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'from_time', 'to_time', 'duration'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'work_shifts';

}
