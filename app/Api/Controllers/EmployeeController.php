<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Controllers;

use HRis\Api\Eloquent\CustomField;
use HRis\Api\Eloquent\CustomFieldValue;
use HRis\Api\Eloquent\Employee;
use HRis\Api\Requests\EmployeeRequest;
use HRis\Api\Transformers\EmployeeTransformer;

class EmployeeController extends BaseController
{
    /**
     * @var CustomFieldValue
     */
    protected $custom_field_value;

    /**
     * @var Employee
     */
    protected $employee;

    /**
     * @var CustomField
     */
    protected $custom_field;

    /**
     * @param Employee         $employee
     * @param CustomField      $custom_field
     * @param CustomFieldValue $custom_field_value
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function __construct(Employee $employee, CustomField $custom_field, CustomFieldValue $custom_field_value)
    {
        $this->employee = $employee;
        $this->custom_field = $custom_field;
        $this->custom_field_value = $custom_field_value;
    }

    /**
     * @param EmployeeRequest $request
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     *
     * @return \Dingo\Api\Http\Response
     */
    public function getByEmployeeId(EmployeeRequest $request)
    {
        $employee_id = $request->get('employee_id');

        $this->initializeCustomFieldValues($employee_id);

        $employee = $this->employee->getEmployeeById($employee_id, null);

        return $this->item($employee, new EmployeeTransformer());
    }

    /**
     * @param $employee_id
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    private function initializeCustomFieldValues($employee_id)
    {
        $employee_id = $this->employee->whereEmployeeId($employee_id)->value('id');
        $custom_fields = $this->custom_field->get();

        foreach ($custom_fields as $custom_field) {
            if (!$this->custom_field_value->whereCustomFieldId($custom_field->id)->whereEmployeeId($employee_id)->first()) {
                $data = [
                    'custom_field_id' => $custom_field->id,
                    'employee_id'     => $employee_id,
                    'value'           => null,
                ];

                $custom_field_value = $this->custom_field_value->firstOrCreate($data);
                $custom_field_value->save();
            }
        }
    }
}
