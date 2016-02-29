<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Transformers;

use HRis\Api\Eloquent\CustomFieldType;

class CustomFieldTypeTransformer extends BaseTransformer
{
    /**
     * Transform object into a generic array.
     *
     * @param CustomFieldType $custom_field_type
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function transform(CustomFieldType $custom_field_type)
    {
        return [
            'id'          => (int) $custom_field_type->id,
            'name'        => $custom_field_type->name,
            'has_options' => $custom_field_type->has_options,
        ];
    }
}
