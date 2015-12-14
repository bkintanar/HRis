<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Controllers\Profile;

use Exception;
use HRis\Api\Controllers\BaseController;
use HRis\Api\Eloquent\Employee;
use HRis\Api\Requests\Profile\PersonalContactDetailsRequest;
use Illuminate\Support\Facades\Config;

class PersonalDetailsController extends BaseController
{
    /**
     * @var Employee
     */
    private $employee;

    /**
     * @param Employee $employee
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function __construct(Employee $employee)
    {
        $this->middleware('jwt.auth');

        $this->employee = $employee;
    }

    /**
     * Updates the Profile - Personal Details and Contact Details.
     *
     * @param PersonalContactDetailsRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function update(PersonalContactDetailsRequest $request)
    {
        $_employee = $request->get('employee');

        $id = $_employee['id'];
        $employee_id = $_employee['employee_id'];

        $employee = $this->employee->whereId($id)->first();

        if (!$employee || !$employee_id || $employee_id == Config::get('company.employee_id_prefix').'____') {
            return response()->json(['error' => UNABLE_UPDATE_MESSAGE], 500);
        }

        // If user is trying to update the employee_id to a used employee_id.
        $original_employee_id = $this->employee->whereEmployeeId($employee_id)->pluck('id');
        if ($id != $original_employee_id && !is_null($original_employee_id)) {
            return response()->json(['error' => EMPLOYEE_ID_IN_MESSAGE], 405);
        }

        try {
            $attributes = array_filter(array_slice($request->get('employee'), 0, 33));

            $employee->update($attributes);
        } catch (Exception $e) {
            return response()->json(['error' => UNABLE_UPDATE_MESSAGE], 500);
        }

        return response()->json(['employee' => $employee, 'text' => SUCCESS_UPDATE_MESSAGE, 'code' => 200]);
    }
}
