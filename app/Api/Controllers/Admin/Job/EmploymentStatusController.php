<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Controllers\Admin\Job;

use HRis\Api\Controllers\BaseController;
use HRis\Api\Eloquent\EmploymentStatus;
use HRis\Api\Requests\Admin\Job\EmploymentStatusRequest;
use Swagger\Annotations as SWG;

/**
 * Class EmploymentStatusController.
 */
class EmploymentStatusController extends BaseController
{
    /**
     * @var EmploymentStatus
     */
    protected $employment_status;

    /**
     * @param EmploymentStatus $employment_status
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function __construct(EmploymentStatus $employment_status)
    {
        $this->employment_status = $employment_status;
    }

    /**
     * Delete the Admin - Employment Status.
     *
     * @SWG\Delete(
     *     path="/admin/job/employment-status/{employment_status}",
     *     description="This route provides the ability to delete an Employment Status.",
     *     tags={"Administration"},
     *     consumes={"application/json"},
     *     summary="Deletes an Employment Status.",
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
     *     @SWG\Response(response="500", description="No query results for model [HRis\\Api\\Eloquent\\EmploymentStatus].",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code", "debug"},
     *             @SWG\Property(property="message", type="string", default="No query results for model [HRis\\Api\\Eloquent\\EmploymentStatus].", description="Status message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=500, description="Status code from server"),
     *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="employment_status",
     *         in="path",
     *         description="Employment status id to be deleted",
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
     * @param EmploymentStatus        $employment_status
     * @param EmploymentStatusRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function destroy(EmploymentStatus $employment_status, EmploymentStatusRequest $request)
    {
        return $this->destroyModel($employment_status, $this->employment_status);
    }

    /**
     * Retrieve the Admin - Employment Status.
     *
     * @SWG\Get(
     *     path="/admin/job/employment-status",
     *     tags={"Administration"},
     *     consumes={"application/json"},
     *     summary="Retrieve the Admin - Employment Status.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"data", "table", "message", "status_code"},
     *             @SWG\Property(property="data", type="object",
     *                 @SWG\Property(property="total", type="integer", default=22),
     *                 @SWG\Property(property="per_page", type="integer", default=10),
     *                 @SWG\Property(property="current_page", type="integer", default=1),
     *                 @SWG\Property(property="last_page", type="integer", default=3),
     *                 @SWG\Property(property="next_page_url", type="string", default="https://api.hris.dev/api/admin/job/employment-status?page=2"),
     *                 @SWG\Property(property="prev_page_url", type="string", default="null"),
     *                 @SWG\Property(property="from", type="integer", default=1),
     *                 @SWG\Property(property="to", type="integer", default=10),
     *                 @SWG\Property(property="data", type="array",
     *                     @SWG\Items(ref="#/definitions/EmploymentStatus"),
     *                 ),
     *             ),
     *             @SWG\Property(property="table", type="object",
     *                 @SWG\Property(property="title", type="string", default="Employment Status"),
     *                 @SWG\Property(property="permission", type="string", default="admin.job.employment-status"),
     *                 @SWG\Property(property="headers", type="array",
     *                     @SWG\Items(title="Id", type="string", default="Id"),
     *                 ),
     *                 @SWG\Property(property="model", type="object",
     *                     @SWG\Property(property="singular", type="string", default="employment_status"),
     *                     @SWG\Property(property="plural", type="string", default="employment_statuses"),
     *                     @SWG\Property(property="dashed", type="string", default="employment-statuses"),
     *                 ),
     *                 @SWG\Property(property="data", type="array",
     *                     @SWG\Items(ref="#/definitions/EmploymentStatus"),
     *                 ),
     *             ),
     *             @SWG\Property(property="message", type="string", default="Record successfully added.", description="Status message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=200, description="Status code from server"),
     *         )
     *     ),
     *     @SWG\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for pagination",
     *         required=true,
     *         type="string",
     *         default="1"
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
     * @param EmploymentStatusRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function index(EmploymentStatusRequest $request)
    {
        $employment_statuses = $this->employment_status->paginate(ROWS_PER_PAGE);

        return $this->responseAPI(200, SUCCESS_RETRIEVE_MESSAGE, ['data' => $employment_statuses, 'table' => $this->setupDataTable($employment_statuses)]);
    }

    /**
     * Setup table for employment status.
     *
     * @param $employment_statuses
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    protected function setupDataTable($employment_statuses)
    {
        $table = [];

        $table['title'] = 'Employment Statuses';
        $table['permission'] = 'admin.job.employment-status';
        $table['headers'] = ['Id', 'Name'];
        $table['model'] = [
            'singular' => 'employment_status',
            'plural'   => 'employment_statuses',
            'dashed'   => 'employment-statuses',
        ];
        $table['items'] = $employment_statuses;

        return $table;
    }

    /**
     * Save the Admin - Employment Status.
     *
     * @SWG\Post(
     *     path="/admin/job/employment-status",
     *     tags={"Administration"},
     *     consumes={"application/json"},
     *     summary="Save the Admin - Employment Status.",
     *     @SWG\Response(response="201", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"employment_status", "message", "status_code"},
     *             @SWG\Property(property="employment_status", ref="#/definitions/EmploymentStatus"),
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
     *         name="employment_status",
     *         in="body",
     *         required=true,
     *         @SWG\Property(ref="#/definitions/EmploymentStatus")
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
     * @param EmploymentStatusRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function store(EmploymentStatusRequest $request)
    {
        return $this->storeModel($request, $this->employment_status, 'employment_status');
    }

    /**
     * Get a single instance of Employment Status.
     *
     * @SWG\Get(
     *     path="/admin/job/employment-status/1",
     *     tags={"Administration"},
     *     consumes={"application/json"},
     *     summary="Get a single instance of Employment Status.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"employment_status", "message", "status_code"},
     *             @SWG\Property(property="employment_status", ref="#/definitions/EmploymentStatus"),
     *             @SWG\Property(property="message", type="string", default="Record successfully retrieved.", description="Status message from server"),
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
     *     @SWG\Response(response="404", description="404 Not Found",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"message", "status_code"},
     *             @SWG\Property(property="message", type="string", default="404 Not Found", description="Status message from server"),
     *             @SWG\Property(property="status_code", type="integer", default=404, description="Status code from server"),
     *             @SWG\Property(property="debug", type="object", description="Debug back trace"),
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
     * @param EmploymentStatus $employment_status
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function show(EmploymentStatus $employment_status)
    {
        return $this->responseAPI(200, SUCCESS_RETRIEVE_MESSAGE, compact('employment_status'));
    }

    /**
     * Update the Admin - Employment Status.
     *
     * @SWG\Patch(
     *     path="/admin/job/employment-status",
     *     tags={"Administration"},
     *     consumes={"application/json"},
     *     summary="Update the Admin - Employment Status.",
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
     *         name="employment_status",
     *         in="body",
     *         required=true,
     *         description="employment status object that needs to be updated",
     *         @SWG\Property(ref="#/definitions/EmploymentStatus")
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
     * @param EmploymentStatusRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function update(EmploymentStatusRequest $request)
    {
        return $this->updateModel($request, $this->employment_status, ['name', 'class']);
    }
}
