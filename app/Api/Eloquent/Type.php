<?php

namespace HRis\Api\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'typeable_id',
        'typeable_type',
    ];
}
