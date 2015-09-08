<?php

namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'description',
        'scheduled_at',
    ];

    protected $dates = ['scheduled_at'];
}
