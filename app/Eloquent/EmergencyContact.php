<?php

namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EmergencyContact
 * @package HRis\Eloquent
 */
class EmergencyContact extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
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

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'emergency_contacts';
}
