<?php

namespace HRis\Api\Transformers;

use HRis\Api\Eloquent\CustomField;
use League\Fractal\TransformerAbstract;

class CustomFieldTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include.
     *
     * @var array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    protected $defaultIncludes = [
        'custom_field_section',
        'custom_field_type',
    ];

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
        ];
    }

    /**
     * Include CustomFieldSection.
     *
     * @param CustomField $custom_field
     *
     * @return \League\Fractal\Resource\Item
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeCustomFieldSection(CustomField $custom_field)
    {
        $custom_field_section = $custom_field->custom_field_section;

        return $this->item($custom_field_section, new CustomFieldSectionTransformer());
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
        $custom_field_type = $custom_field->custom_field_type;

        return $this->item($custom_field_type, new CustomFieldTypeTransformer());
    }
}
