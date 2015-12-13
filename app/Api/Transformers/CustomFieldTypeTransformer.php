<?php

namespace HRis\Api\Transformers;

use HRis\Api\Eloquent\CustomFieldType;
use League\Fractal\TransformerAbstract;

class CustomFieldTypeTransformer extends TransformerAbstract
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
