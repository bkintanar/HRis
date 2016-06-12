<?php

/*
 * This file is part of the HRis Software package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @version    alpha
 *
 * @author     Bertrand Kintanar <bertrand.kintanar@gmail.com>
 * @license    BSD License (3-clause)
 * @copyright  (c) 2014-2016, b8 Studios, Ltd
 *
 * @link       http://github.com/HB-Co/HRis
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
        return $this->belongsTo(Navlink::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function customFields()
    {
        return $this->hasMany(CustomField::class);
    }
}
