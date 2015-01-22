<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

class Nationality extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'nationalities';

    public $timestamps = false;
}
