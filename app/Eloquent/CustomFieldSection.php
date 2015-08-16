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
 * Class CustomFieldSection.
 */
class CustomFieldSection extends Model
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
    protected $fillable = ['name', 'screen_id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pim_custom_field_sections';

    /**
     * A custom field section object belongs to on screen.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @author Bertrand Kintanar
     */
    public function screen()
    {
        return $this->belongsTo('HRis\Eloquent\Navlink', 'screen_id', 'id');
    }

    public function customFields()
    {
        return $this->hasMany('HRis\Eloquent\CustomField', 'pim_custom_field_section_id', 'id');
    }
}
