<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Controllers\Admin\Job;

use Exception;
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
     *     path="/admin/job/employment-status",
     *     tags={"Administration"},
     *     consumes={"application/json"},
     *     summary="Delete the Admin - Employment Status.",
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
     * @param EmploymentStatusRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function destroy(EmploymentStatusRequest $request)
    {
        $employment_status_id = $request->get('id');

        $response_code = $this->employment_status->whereId($employment_status_id)->delete();

        if (!$response_code) {
            return $this->response()->array(['message' => UNABLE_DELETE_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        return $this->response()->array(['message' => SUCCESS_DELETE_MESSAGE, 'status_code' => 200])->statusCode(200);
    }

    /**
     * Retrieve the Admin - Employment Status.
     *
     * @SWG\Get(
     *     path="/admin/job/employment-status",
     *     tags={"Administration"},
     *     consumes={"application/json"},
     *     summary="Save the Admin - Employment Status.",
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
     *                     @SWG\Items(title="employment_status", ref="#/definitions/EmploymentStatus"),
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
     *                 @SWG\Property(property="data", type="array"),
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
     * @return \Illuminate\View\View
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function index(EmploymentStatusRequest $request)
    {
        $employment_statuses = $this->employment_status->paginate(ROWS_PER_PAGE);

        $response['data'] = $employment_statuses;
        $response['table'] = $this->setupDataTable($employment_statuses);
        $response['message'] = SUCCESS_RETRIEVE_MESSAGE;
        $response['status_code'] = 200;

        return $this->response()->array($response)->statusCode(200);
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
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function store(EmploymentStatusRequest $request)
    {
        try {
            $employment_status = $this->employment_status->create($request->all());
        } catch (Exception $e) {
            return $this->response()->array(['message' => UNABLE_ADD_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        return $this->response()->array(['employment_status' => $employment_status, 'message' => SUCCESS_ADD_MESSAGE, 'status_code' => 201])->statusCode(201);
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
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function update(EmploymentStatusRequest $request)
    {
        $employment_status = $this->employment_status->whereId($request->get('id'))->first();

        if (!$employment_status) {
            return $this->response()->array(['message' => UNABLE_RETRIEVE_MESSAGE, 'status_code' => 404])->statusCode(404);
        }
        try {
            $employment_status->update($request->only(['name', 'description']));
        } catch (Exception $e) {
            return $this->response()->array(['message' => UNABLE_UPDATE_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        return $this->response()->array(['message' => SUCCESS_UPDATE_MESSAGE, 'status_code' => 200])->statusCode(200);
    }
}
