<?php

namespace HRis\Api\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Timelog extends Model
{
    protected $fillable = [
        'type_id',
        'holiday_id',
        'employee_id',
        'schedule_id',
        'in',
        'out',
        'rendered_hours',
    ];

    protected $dates = ['in', 'out'];

    /**
     * Automatically update rendered hours everytime
     * "in" field is occupied or changed.
     *
     * @author Harlequin Doyon
     */
    public function setInAttribute($in)
    {
        $this->attributes['in'] = $in;

        if (!empty($this->attributes['in']) && !empty($this->attributes['out'])) {
            $out = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['out']);
            $hours = $in->diffInHours($out);
            $mins = $in->diffInMinutes($out);

            $this->attributes['rendered_hours'] = number_format(($hours * 60 + $mins) / 60, 2);
        }
    }

    /**
     * Automatically update rendered hours everytime
     * "out" field is occupied or changed.
     *
     * @author Harlequin Doyon
     */
    public function setOutAttribute($out)
    {
        $this->attributes['out'] = $out;

        if (!empty($this->attributes['in']) && !empty($this->attributes['out'])) {
            $in = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['in']);
            $hours = $in->diffInHours($out);
            $mins = $in->diffInMinutes($out);

            $this->attributes['rendered_hours'] = number_format(($hours * 60 + $mins) / 60, 2);
        }
    }
}
