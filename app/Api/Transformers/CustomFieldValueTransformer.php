<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Transformers;

use HRis\Api\Eloquent\CustomFieldValue;
use League\Fractal\TransformerAbstract;

class CustomFieldValueTransformer extends TransformerAbstract
{
    /**
     * Transform object into a generic array.
     *
     * @param CustomFieldValue $custom_field_value
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function transform(CustomFieldValue $custom_field_value)
    {
        return [
            'id'              => (int) $custom_field_value->id,
            'custom_field_id' => (int) $custom_field_value->custom_field_id,
            'employee_id'     => (int) $custom_field_value->employee_id,
            'value'           => $custom_field_value->value,
        ];
    }

    /**
     * Include CustomField.
     *
     * @param CustomFieldValue $custom_field_value
     *
     * @return \League\Fractal\Resource\Item
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeCustomField(CustomFieldValue $custom_field_value)
    {
        $custom_field = $custom_field_value->customField;

        return $this->item($custom_field, new CustomFieldTransformer());
    }

    /**
     * Include Employee.
     *
     * @param CustomFieldValue $custom_field_value
     *
     * @return \League\Fractal\Resource\Item
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeEmployee(CustomFieldValue $custom_field_value)
    {
        $employee = $custom_field_value->employee;

        return $this->item($employee, new EmployeeTransformer());
    }
}
