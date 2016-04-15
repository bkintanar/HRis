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
use HRis\Api\Eloquent\PayGrade;
use HRis\Api\Requests\Admin\Job\PayGradeRequest;
use Swagger\Annotations as SWG;

/**
 * Class PayGradesController.
 */
class PayGradesController extends BaseController
{
    /**
     * @var PayGrade
     */
    protected $pay_grade;

    /**
     * @param PayGrade $pay_grade
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function __construct(PayGrade $pay_grade)
    {
        $this->pay_grade = $pay_grade;
    }

    /**
     * Delete the Admin - Pay Grade.
     *
     * @SWG\Delete(
     *     path="/admin/job/pay-grades",
     *     tags={"Administration"},
     *     consumes={"application/json"},
     *     summary="Delete the Admin - Pay Grade.",
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
     *         description="Pay grade id to be deleted",
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
     * @param PayGradeRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function destroy(PayGradeRequest $request)
    {
        return $this->destroyModel($request, $this->pay_grade);
    }

    /**
     * Retrieve the Admin - Pay Grade.
     *
     * @SWG\Get(
     *     path="/admin/job/pay-grades",
     *     tags={"Administration"},
     *     consumes={"application/json"},
     *     summary="Save the Admin - Pay Grade.",
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
     *                 @SWG\Property(property="next_page_url", type="string", default="https://api.hris.dev/api/admin/job/pay-grades?page=2"),
     *                 @SWG\Property(property="prev_page_url", type="string", default="null"),
     *                 @SWG\Property(property="from", type="integer", default=1),
     *                 @SWG\Property(property="to", type="integer", default=10),
     *                 @SWG\Property(property="data", type="array",
     *                     @SWG\Items(ref="#/definitions/PayGrade"),
     *                 ),
     *             ),
     *             @SWG\Property(property="table", type="object",
     *                 @SWG\Property(property="title", type="string", default="Pay Grade"),
     *                 @SWG\Property(property="permission", type="string", default="admin.job.pay-grades"),
     *                 @SWG\Property(property="headers", type="array",
     *                     @SWG\Items(title="Id", type="string", default="Id"),
     *                 ),
     *                 @SWG\Property(property="model", type="object",
     *                     @SWG\Property(property="singular", type="string", default="pay_grade"),
     *                     @SWG\Property(property="plural", type="string", default="pay_grades"),
     *                     @SWG\Property(property="dashed", type="string", default="pay-grades"),
     *                 ),
     *                 @SWG\Property(property="data", type="array",
     *                     @SWG\Items(ref="#/definitions/PayGrade"),
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
     * @param PayGradeRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function index(PayGradeRequest $request)
    {
        $pay_grades = $this->pay_grade->paginate(ROWS_PER_PAGE);

        return $this->responseAPI(200, SUCCESS_RETRIEVE_MESSAGE, ['data' => $pay_grades, 'table' => $this->setupDataTable($pay_grades)]);
    }

    /**
     * Setup table for pay grade.
     *
     * @param $pay_grades
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    protected function setupDataTable($pay_grades)
    {
        $table = [];

        $table['title'] = 'Pay Grades';
        $table['permission'] = 'admin.job.pay-grades';
        $table['headers'] = ['Id', 'Pay Grade', 'Minimum Salary', 'Maximum Salary'];
        $table['model'] = [
            'singular' => 'pay_grade',
            'plural'   => 'pay_grades',
            'dashed'   => 'pay-grades',
        ];
        $table['items'] = $pay_grades;

        return $table;
    }

    /**
     * Save the Admin - Pay Grade.
     *
     * @SWG\Post(
     *     path="/admin/job/pay-grades",
     *     tags={"Administration"},
     *     consumes={"application/json"},
     *     summary="Save the Admin - Pay Grade.",
     *     @SWG\Response(response="201", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"pay_grade", "message", "status_code"},
     *             @SWG\Property(property="pay_grade", ref="#/definitions/PayGrade"),
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
     *         name="pay_grade",
     *         in="body",
     *         required=true,
     *         @SWG\Property(ref="#/definitions/PayGrade")
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
     * @param PayGradeRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function store(PayGradeRequest $request)
    {
        return $this->storeModel($request, $this->pay_grade, 'pay_grade');
    }

    /**
     * Get a single instance of Pay Grade.
     *
     * @SWG\Get(
     *     path="/admin/job/pay-grades/1",
     *     tags={"Administration"},
     *     consumes={"application/json"},
     *     summary="Get a single instance of Pay Grade.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"employment_status", "message", "status_code"},
     *             @SWG\Property(property="employment_status", ref="#/definitions/PayGrade"),
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
     * @param PayGrade $pay_grade
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function show(PayGrade $pay_grade)
    {
        return $this->responseAPI(200, SUCCESS_RETRIEVE_MESSAGE, compact('pay_grade'));
    }

    /**
     * Update the Admin - Pay Grade.
     *
     * @SWG\Patch(
     *     path="/admin/job/pay-grades",
     *     tags={"Administration"},
     *     consumes={"application/json"},
     *     summary="Update the Admin - Pay Grade.",
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
     *         name="pay_grade",
     *         in="body",
     *         required=true,
     *         description="pay grade object that needs to be updated",
     *         @SWG\Property(ref="#/definitions/PayGrade")
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
     * @param PayGradeRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function update(PayGradeRequest $request)
    {
        return $this->updateModel($request, $this->pay_grade);
    }
}
