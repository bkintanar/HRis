<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Transformers;

use HRis\Api\Eloquent\CustomFieldSection;
use League\Fractal\TransformerAbstract;

class CustomFieldSectionTransformer extends TransformerAbstract
{
    /**
     * Transform object into a generic array.
     *
     * @param CustomFieldSection $custom_field_section
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function transform(CustomFieldSection $custom_field_section)
    {
        return [
            'id'        => (int) $custom_field_section->id,
            'name'      => $custom_field_section->name,
            'screen_id' => (int) $custom_field_section->screen_id,
        ];
    }
}
