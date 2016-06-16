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
use Irradiate\Eloquent\EmployeeSupervisor;
use HRis\Api\Requests\Profile\ReportsToRequest;
use Swagger\Annotations as SWG;

class ReportsToController extends BaseController
{
    /**
     * @var Employee
     */
    protected $employee;

    /**
     * @var EmployeeSupervisor
     */
    protected $employee_supervisor;

    /**
     * @param Employee           $employee
     * @param EmployeeSupervisor $employee_supervisor
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function __construct(Employee $employee, EmployeeSupervisor $employee_supervisor)
    {
        $this->employee = $employee;
        $this->employee_supervisor = $employee_supervisor;
    }

    /**
     * Stores a single instance of Employee Supervisor.
     *
     * @SWG\Post(
     *     path="/profile/reports-to",
     *     description="This route provides the ability to store a single instance of Employee Supervisor.",
     *     tags={"Employee Profiles"},
     *     consumes={"application/json"},
     *     summary="Stores a single instance of Employee Supervisor.",
     *     @SWG\Response(response="201", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"supervisor", "message", "status_code"},
     *             @SWG\Property(property="supervisor", ref="#/definitions/Employee"),
     *             @SWG\Property(property="message", type="string", default="Record successfully added.", description="Status message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=201, description="Status code from server"),
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
     *     @SWG\Response(response="422", description="Unable to add record to the database.",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code"},
     *             @SWG\Property(property="message", type="string", default="Unable to add record to the database.", description="Status message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=422, description="Status code from server"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="supervisor",
     *         in="body",
     *         required=true,
     *         @SWG\Property(ref="#/definitions/Employee")
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
     * @param ReportsToRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function store(ReportsToRequest $request)
    {
        return $this->storeModel($request, $this->employee_supervisor, 'supervisor');
    }

    /**
     * Updates a single instance of Employee Supervisor.
     *
     * @SWG\Patch(
     *     path="/profile/reports-to",
     *     description="This route provides the ability to update a single instance of Employee Supervisor.",
     *     tags={"Employee Profiles"},
     *     consumes={"application/json"},
     *     summary="Updates a single instance of Employee Supervisor.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code"},
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
     *     @SWG\Response(response="404", description="Unable to retrieve record from database.",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code", "debug"},
     *             @SWG\Property(property="message", type="string", default="Unable to retrieve record from database.", description="Error message from server"),
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
     *         name="supervisor",
     *         in="body",
     *         required=true,
     *         description="employee's supervisor object that needs to be updated",
     *         @SWG\Property(ref="#/definitions/Employee")
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
     * @param ReportsToRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function update(ReportsToRequest $request)
    {
        return $this->updateModel($request, $this->employee_supervisor);
    }

    /**
     * Deletes a single instance of EmployeeSupervisor.
     *
     * @SWG\Delete(
     *     path="/profile/reports-to/{employee_supervisor}",
     *     description="This route provides the ability to delete a EmployeeSupervisor.",
     *     tags={"Employee Profiles"},
     *     consumes={"application/json"},
     *     summary="Deletes a single instance of EmployeeSupervisor.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code"},
     *             @SWG\Property(property="message", type="string", default="Record successfully deleted.", description="Status message from server"),
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
     *     @SWG\Response(response="422", description="422 Unprocessable Entity",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code"},
     *             @SWG\Property(property="message", type="string", default="422 Unprocessable Entity", description="Status message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=422, description="Status code from server"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="employee_supervisor",
     *         in="path",
     *         description="Employee supervisor id to be deleted",
     *         required=true,
     *         type="integer",
     *         format="int64",
     *         default=1,
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
     * @param EmployeeSupervisor $employee_supervisor
     * @param ReportsToRequest   $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function destroy(EmployeeSupervisor $employee_supervisor, ReportsToRequest $request)
    {
        return $this->destroyModel($employee_supervisor, $this->employee_supervisor);
    }
}
