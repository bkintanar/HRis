<?php

namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'is_strict',
        'employee_id',
        'weekday',
        'in',
        'out',
        'hours',
    ];
}
