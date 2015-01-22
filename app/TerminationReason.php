<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

class TerminationReason extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'termination_reasons';

    public $timestamps = false;

}
