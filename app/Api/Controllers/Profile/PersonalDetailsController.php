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

namespace HRis\Api\Controllers\Profile;

use Irradiate\Api\Controllers\BaseController;
use Irradiate\Eloquent\Employee;
use HRis\Api\Requests\Profile\PersonalContactDetailsRequest;
use Illuminate\Support\Facades\Config;
use Swagger\Annotations as SWG;

/**
 * Updates a single instance of Employee Personal Details.
 *
 * @SWG\Patch(
 *     path="/profile/personal-details",
 *     description="This route provides the ability to update a single instance of Employee Personal Details.",
 *     tags={"Employee Profiles"},
 *     consumes={"application/json"},
 *     summary="Updates a single instance of Employee Personal Details.",
 *     @SWG\Response(response="200", description="Success",
 *         @SWG\Schema(
 *             title="data",
 *             type="object",
 *             required={"employee", "message", "status_code"},
 *             @SWG\Property(property="employee", ref="#/definitions/Employee"),
 *             @SWG\Property(property="message", type="string", default="Record successfully updated.", description="Status message from server"),
 *             @SWG\Property(property="status_code", type="integer", default=200, description="Status code from server"),
 *         )
 *     ),
 *     @SWG\Response(response="400", description="Token not provided",
 *         @SWG\Schema(
 *             title="data",
 *             type="object",
 *             required={"message", "status_code", "debug"},
 *             @SWG\Property(property="message", type="string", default="Token not provided", description="Error message from server"),
 *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
 *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
 *         )
 *     ),
 *     @SWG\Response(response="405", description="Employee Id already in use.",
 *         @SWG\Schema(
 *             title="data",
 *             type="object",
 *             required={"message", "status_code"},
 *             @SWG\Property(property="message", type="string", default="Employee Id already in use.", description="Error message from server"),
 *             @SWG\Property(property="status_code", type="integer", default=405, description="Status code from server"),
 *         )
 *     ),
 *     @SWG\Response(response="422", description="Unable to update record.",
 *         @SWG\Schema(
 *             title="data",
 *             type="object",
 *             required={"message", "status_code"},
 *             @SWG\Property(property="message", type="string", default="Unable to update record.", description="Status message from server"),
 *             @SWG\Property(property="status_code", type="integer", default=422, description="Status code from server"),
 *         )
 *     ),
 *     @SWG\Parameter(
 *         name="employee",
 *         in="body",
 *         description="Employee object that needs to be updated",
 *         required=true,
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
 * Updates a single instance of Employee Contact Details.
 *
 * @SWG\Patch(
 *     path="/profile/contact-details",
 *     description="This route provides the ability to update a single instance of Employee Contact Details.",
 *     tags={"Employee Profiles"},
 *     consumes={"application/json"},
 *     summary="Updates a single instance of Employee Contact Details.",
 *     @SWG\Response(response="200", description="Success",
 *         @SWG\Schema(
 *             title="data",
 *             type="object",
 *             required={"employee", "message", "status_code"},
 *             @SWG\Property(property="employee", ref="#/definitions/Employee"),
 *             @SWG\Property(property="message", type="string", default="Record successfully updated.", description="Status message from server"),
 *             @SWG\Property(property="status_code", type="integer", default=200, description="Status code from server"),
 *         )
 *     ),
 *     @SWG\Response(response="400", description="Token not provided",
 *         @SWG\Schema(
 *             title="data",
 *             type="object",
 *             required={"message", "status_code", "debug"},
 *             @SWG\Property(property="message", type="string", default="Token not provided", description="Error message from server"),
 *             @SWG\Property(property="status_code", type="integer", default=400, description="Status code from server"),
 *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
 *         )
 *     ),
 *     @SWG\Response(response="422", description="Unable to update record.",
 *         @SWG\Schema(
 *             title="data",
 *             type="object",
 *             required={"message", "status_code"},
 *             @SWG\Property(property="message", type="string", default="Unable to update record.", description="Status message from server"),
 *             @SWG\Property(property="status_code", type="integer", default=422, description="Status code from server"),
 *         )
 *     ),
 *     @SWG\Parameter(
 *         name="employee",
 *         in="body",
 *         description="Employee object that needs to be updated",
 *         required=true,
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
        $this->employee = $employee;
    }

    /**
     * Updates the Profile - Personal Details and Contact Details.
     *
     * @param PersonalContactDetailsRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function update(PersonalContactDetailsRequest $request)
    {
        $_employee = $request->get('employee');

        $id = $_employee['id'];
        $employee_id = $_employee['employee_id'];

        $employee = $this->employee->find($id);

        if (!$employee || !$employee_id || $employee_id == Config::get('company.employee_id_prefix').'____') {
            return $this->responseAPI(405, UNABLE_UPDATE_MESSAGE);
        }

        // If user is trying to update the employee_id to a used employee_id.
        $original_employee_id = $this->employee->whereEmployeeId($employee_id)->value('id');
        if ($id != $original_employee_id && !is_null($original_employee_id)) {
            return $this->responseAPI(405, EMPLOYEE_ID_IN_MESSAGE);
        }

        $attributes = array_filter(array_slice($request->get('employee'), 0, 33));

        $employee->update($attributes);

        return $this->responseAPI(200, SUCCESS_UPDATE_MESSAGE, compact('employee'));
    }
}
