<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

class Dependent extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dependents';

    public $timestamps = false;

}
