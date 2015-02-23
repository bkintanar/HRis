<?php namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EmergencyContact
 * @package HRis
 */
class EmergencyContact extends Model {

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'emergency_contacts';

    /**
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'first_name',
        'middle_name',
        'last_name',
        'relationship_id',
        'home_phone',
        'mobile_phone'
    ];

}
