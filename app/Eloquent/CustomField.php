<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomField.
 */
class CustomField extends Model
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
    protected $fillable = ['pim_custom_field_section_id', 'name', 'pim_custom_field_type_id', 'required'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pim_custom_fields';

    public function type()
    {
        return $this->hasOne('HRis\Eloquent\CustomFieldType', 'id', 'pim_custom_field_type_id');
    }
}
