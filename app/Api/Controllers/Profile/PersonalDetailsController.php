<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Controllers\Profile;

use Dingo\Api\Facade\API;
use Exception;
use HRis\Api\Controllers\BaseController;
use HRis\Api\Eloquent\Employee;
use HRis\Api\Requests\Profile\PersonalContactDetailsRequest;
use Illuminate\Support\Facades\Config;

/**
 * Updates the Profile - Personal Details.
 *
 * @SWG\Patch(
 *     path="/profile/personal-details",
 *     tags={"Employee Profiles"},
 *     consumes={"application/json"},
 *     summary="Updates the Profile - Personal Details.",
 *     @SWG\Response(response="200", description="Success",
 *         @SWG\Schema(
 *             title="data",
 *             type="object",
 *             required={"employee", "status"},
 *             @SWG\Property(property="employee", ref="#/definitions/Employee"),
 *             @SWG\Property(property="status", type="string", default="Record successfully updated.", description="Status message from server"),
 *         )
 *     ),
 *     @SWG\Response(response="400", description="Token not provided",
 *         @SWG\Schema(
 *             title="data",
 *             type="object",
 *             @SWG\Property(property="message", type="string", default="Token not provided", description="Error message from server"),
 *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
 *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
 *         )
 *     ),
 *     @SWG\Response(response="405", description="Employee Id already in use.",
 *         @SWG\Schema(
 *             title="data",
 *             type="object",
 *             required={"status"},
 *             @SWG\Property(property="status", type="string", default="Employee Id already in use.", description="Error message from server"),
 *         )
 *     ),
 *     @SWG\Parameter(
 *         name="employee",
 *         in="body",
 *         description="Employee object that needs to be updated",
 *         required=true,
 *         type="object",
 *         @SWG\Schema(title="employee", type="object",
 *             @SWG\Property(property="employee", ref="#/definitions/Employee")
 *         )
 *     ),
 *     @SWG\Parameter(
 *         name="Authorization",
 *         in="header",
 *         description="JWT Token",
 *         required=true,
 *         type="string",
 *         default="Bearer "
 *     ),
 * )
 *
 * Updates the Profile - Contact Details.
 *
 * @SWG\Patch(
 *     path="/profile/contact-details",
 *     tags={"Employee Profiles"},
 *     consumes={"application/json"},
 *     summary="Updates the Profile - Contact Details.",
 *     @SWG\Response(response="200", description="Success",
 *         @SWG\Schema(
 *             title="data",
 *             type="object",
 *             required={"employee", "status"},
 *             @SWG\Property(property="employee", ref="#/definitions/Employee"),
 *             @SWG\Property(property="status", type="string", default="Record successfully updated.", description="Status message from server"),
 *         )
 *     ),
 *     @SWG\Response(response="400", description="Token not provided",
 *         @SWG\Schema(
 *             title="data",
 *             type="object",
 *             @SWG\Property(property="message", type="string", default="Token not provided", description="Error message from server"),
 *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
 *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
 *         )
 *     ),
 *     @SWG\Parameter(
 *         name="employee",
 *         in="body",
 *         description="Employee object that needs to be updated",
 *         required=true,
 *         type="object",
 *         @SWG\Schema(title="employee", type="object",
 *             @SWG\Property(property="employee", ref="#/definitions/Employee")
 *         )
 *     ),
 *     @SWG\Parameter(
 *         name="Authorization",
 *         in="header",
 *         description="JWT Token",
 *         required=true,
 *         type="string",
 *         default="Bearer "
 *     ),
 * )
 *
 * @param PersonalContactDetailsRequest $request
 *
 * @return \Illuminate\Http\JsonResponse
 *
 * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
 */
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

        $employee = $this->employee->findOrFail($id);

        if (!$employee || !$employee_id || $employee_id == Config::get('company.employee_id_prefix').'____') {
            return API::response()->array(['status' => UNABLE_UPDATE_MESSAGE])->statusCode(405);
        }

        // If user is trying to update the employee_id to a used employee_id.
        $original_employee_id = $this->employee->whereEmployeeId($employee_id)->pluck('id');
        if ($id != $original_employee_id && !is_null($original_employee_id)) {
            return API::response()->array(['status' => EMPLOYEE_ID_IN_MESSAGE])->statusCode(405);
        }

        try {
            $attributes = array_filter(array_slice($request->get('employee'), 0, 33));

            $employee->update($attributes);
        } catch (Exception $e) {
            return API::response()->array(['status' => UNABLE_UPDATE_MESSAGE])->statusCode(500);
        }

        return API::response()->array(['employee' => $employee, 'status' => SUCCESS_UPDATE_MESSAGE])->statusCode(200);
    }
}
