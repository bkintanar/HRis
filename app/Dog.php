<?php

namespace HRis;

use Illuminate\Database\Eloquent\Model;

class Dog extends Model
{
    protected $fillable = [ 'name', 'age' ];
}
