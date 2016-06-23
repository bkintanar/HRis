<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Controllers\Profile;

use HRis\Api\Controllers\BaseController;
use HRis\Api\Eloquent\Dependent;
use HRis\Api\Eloquent\Employee;
use HRis\Api\Requests\Profile\DependentsRequest;
use Swagger\Annotations as SWG;

class DependentsController extends BaseController
{
    /**
     * @var Employee
     */
    protected $employee;

    /**
     * @var Dependent
     */
    protected $dependent;

    /**
     * @param Employee  $employee
     * @param Dependent $dependent
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function __construct(Employee $employee, Dependent $dependent)
    {
        $this->employee = $employee;
        $this->dependent = $dependent;
    }

    /**
     * Save the Profile - Dependents.
     *
     * @SWG\Post(
     *     path="/profile/dependents",
     *     tags={"Employee Profiles"},
     *     consumes={"application/json"},
     *     summary="Save the Profile - Dependents.",
     *     @SWG\Response(response="201", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"dependent", "message", "status_code"},
     *             @SWG\Property(property="emergency_contact", ref="#/definitions/Dependent"),
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
     *         name="dependent",
     *         in="body",
     *         required=true,
     *         @SWG\Property(ref="#/definitions/Dependent")
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
     * @param DependentsRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function store(DependentsRequest $request)
    {
        return $this->storeModel($request, $this->dependent, 'dependent');
    }

    /**
     * Update the Profile - Dependents.
     *
     * @SWG\Patch(
     *     path="/profile/dependents",
     *     tags={"Employee Profiles"},
     *     consumes={"application/json"},
     *     summary="Update the Profile - Dependents.",
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
     *         name="dependent",
     *         in="body",
     *         required=true,
     *         description="employee's dependent object that needs to be updated",
     *         @SWG\Property(ref="#/definitions/Dependent")
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
     * @param DependentsRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function update(DependentsRequest $request)
    {
        return $this->updateModel($request, $this->dependent);
    }

    /**
     * Delete the Profile - Dependents.
     *
     * @SWG\Delete(
     *     path="/profile/dependents",
     *     tags={"Employee Profiles"},
     *     consumes={"application/json"},
     *     summary="Delete the Profile - Dependents.",
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
     *     @SWG\Response(response="422", description="Unable to delete record from the database.",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code"},
     *             @SWG\Property(property="message", type="string", default="Unable to delete record from the database.", description="Status message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=422, description="Status code from server"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="id",
     *         in="formData",
     *         description="Employee's dependent id to be deleted",
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
     * @param DependentsRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function destroy(DependentsRequest $request)
    {
        return $this->destroyModel($request, $this->dependent);
    }
}
