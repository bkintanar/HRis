<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'skills';

    public $timestamps = false;

    public function employees()
    {
        return $this->belongsToMany('HRis\Employee');
    }

}
