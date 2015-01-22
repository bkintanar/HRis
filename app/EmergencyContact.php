<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'emergency_contacts';

    public $timestamps = false;

}
