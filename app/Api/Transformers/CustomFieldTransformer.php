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
 
namespace HRis\Api\Transformers;

use HRis\Api\Eloquent\CustomField;

class CustomFieldTransformer extends BaseTransformer
{
    /**
     * Transform object into a generic array.
     *
     * @param CustomField $custom_field
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function transform(CustomField $custom_field)
    {
        return [
            'id'                      => (int) $custom_field->id,
            'custom_field_section_id' => (int) $custom_field->custom_field_section_id,
            'name'                    => $custom_field->name,
            'custom_field_type_id'    => (int) $custom_field->custom_field_type_id,
            'required'                => $custom_field->required,
            'mask'                    => $custom_field->mask,
            'options'                 => $custom_field->options->list('name', 'id'),
            'type'                    => $custom_field->type,
        ];
    }

    /**
     * Include CustomFieldType.
     *
     * @param CustomField $custom_field
     *
     * @return \League\Fractal\Resource\Item
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeCustomFieldType(CustomField $custom_field)
    {
        $custom_field_type = $custom_field->type;

        return $this->item($custom_field_type, new CustomFieldTypeTransformer());
    }
}
