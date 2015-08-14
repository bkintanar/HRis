<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TimeLog.
 */
class TimeLog extends Model
{
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
    protected $fillable = ['face_id', 'swipe_date', 'swipe_time', 'swipe_datetime'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'time_log';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @author Bertrand Kintanar
     */
    public function employee()
    {
        return $this->belongsTo('HRis\Eloquent\Employee', 'face_id', 'face_id');
    }
}
