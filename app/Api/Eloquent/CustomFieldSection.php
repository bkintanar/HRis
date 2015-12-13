<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Eloquent;

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
    protected $table = 'custom_field_sections';

    /**
     * A custom field section object belongs to on screen.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function screen()
    {
        return $this->belongsTo('HRis\Api\Eloquent\Navlink', 'screen_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function customFields()
    {
        return $this->hasMany('HRis\Api\Eloquent\CustomField', 'custom_field_section_id', 'id');
    }
}
