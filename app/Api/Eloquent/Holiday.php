<?php

namespace HRis\Api\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $fillable = [
        'type_id',
        'name',
        'description',
        'date',
    ];

    protected $dates = ['date'];
}
