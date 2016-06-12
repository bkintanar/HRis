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
