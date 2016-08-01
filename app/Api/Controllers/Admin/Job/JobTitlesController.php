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

namespace HRis\Api\Controllers\Admin\Job;

use HRis\Api\Requests\Admin\Job\JobTitleRequest;
use Irradiate\Api\Controllers\BaseController;
use Irradiate\Eloquent\JobTitle;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class JobTitlesController.
 */
class JobTitlesController extends BaseController
{
    /**
     * @var JobTitle
     */
    protected $job_title;

    /**
     * @param JobTitle $job_title
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function __construct(JobTitle $job_title)
    {
        $this->job_title = $job_title;
    }

    /**
     * Deletes a single instance of Job Title.
     *
     * @SWG\Delete(
     *     path="/admin/job/titles/{job_title}",
     *     description="This route provides the ability to delete a Job Title.",
     *     tags={"Administration"},
     *     consumes={"application/json"},
     *     summary="Deletes a single instance of Employment Status.",
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
     *         name="job_title",
     *         in="path",
     *         description="Job title id to be deleted",
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
     * @param JobTitle        $job_title
     * @param JobTitleRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function destroy(JobTitle $job_title, JobTitleRequest $request)
    {
        return $this->destroyModel($job_title, $this->job_title);
    }

    /**
     * Retrieves a paginate aware collection of Job Title.
     *
     * @SWG\Get(
     *     path="/admin/job/titles",
     *     description="This route provides the ability to retrieve a paginate aware collection of Job Titles.",
     *     tags={"Administration"},
     *     consumes={"application/json"},
     *     summary="Retrieves a paginate aware collection of Job Title.",
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
     *                 @SWG\Property(property="next_page_url", type="string", default="https://api.hris.dev/api/admin/job/titles?page=2"),
     *                 @SWG\Property(property="prev_page_url", type="string", default="null"),
     *                 @SWG\Property(property="from", type="integer", default=1),
     *                 @SWG\Property(property="to", type="integer", default=10),
     *                 @SWG\Property(property="data", type="array",
     *                     @SWG\Items(ref="#/definitions/JobTitle"),
     *                 ),
     *             ),
     *             @SWG\Property(property="table", type="object",
     *                 @SWG\Property(property="title", type="string", default="Job Title"),
     *                 @SWG\Property(property="permission", type="string", default="admin.job.titles"),
     *                 @SWG\Property(property="headers", type="array",
     *                     @SWG\Items(title="Id", type="string", default="Id"),
     *                 ),
     *                 @SWG\Property(property="model", type="object",
     *                     @SWG\Property(property="singular", type="string", default="job_title"),
     *                     @SWG\Property(property="plural", type="string", default="job_titles"),
     *                     @SWG\Property(property="dashed", type="string", default="job-titles"),
     *                 ),
     *                 @SWG\Property(property="data", type="array",
     *                     @SWG\Items(ref="#/definitions/JobTitle"),
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
     * @param JobTitleRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function index(JobTitleRequest $request)
    {
        $job_titles = $this->job_title->paginate(ROWS_PER_PAGE);

        $data = ['data' => $job_titles, 'table' => $this->setupDataTable($job_titles)];

        return $this->responseAPI(Response::HTTP_OK, SUCCESS_RETRIEVE_MESSAGE, $data);
    }

    /**
     * Setup table for job title.
     *
     * @param $job_titles
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    protected function setupDataTable($job_titles)
    {
        $table = [];

        $table['title'] = 'Job Titles';
        $table['permission'] = 'admin.job.titles';
        $table['headers'] = ['Id', 'Name', 'Description'];
        $table['model'] = [
            'singular' => 'job_title',
            'plural'   => 'job_titles',
            'dashed'   => 'job-titles',
        ];
        $table['items'] = $job_titles;

        return $table;
    }

    /**
     * Stores a single instance of Job Title.
     *
     * @SWG\Post(
     *     path="/admin/job/titles",
     *     description="This route provides the ability to store a single instance of Job Title.",
     *     tags={"Administration"},
     *     consumes={"application/json"},
     *     summary="Stores a single instance of Employment Status.",
     *     @SWG\Response(response="201", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"job_title", "message", "status_code"},
     *             @SWG\Property(property="job_title", ref="#/definitions/JobTitle"),
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
     *         name="job_title",
     *         in="body",
     *         required=true,
     *         @SWG\Property(ref="#/definitions/JobTitle")
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
     * @param JobTitleRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function store(JobTitleRequest $request)
    {
        return $this->storeModel($request, $this->job_title, 'job_title');
    }

    /**
     * Retrieves a single instance of Job Title.
     *
     * @SWG\Get(
     *     path="/admin/job/titles/{job_title}",
     *     description="This route provides the ability to retrieve a single instance of Job Title.",
     *     tags={"Administration"},
     *     consumes={"application/json"},
     *     summary="Retrieves a single instance of Job Title.",
     *     @SWG\Response(response="200", description="Success",
     *         @SWG\Schema(
     *             title="data",
     *             type="object",
     *             required={"employment_status", "message", "status_code"},
     *             @SWG\Property(property="employment_status", ref="#/definitions/JobTitle"),
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
     *         name="job_title",
     *         in="path",
     *         description="Job title id to be retrieved.",
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
     * @param JobTitle $job_title
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function show(JobTitle $job_title)
    {
        return $this->responseAPI(Response::HTTP_OK, SUCCESS_RETRIEVE_MESSAGE, compact('job_title'));
    }

    /**
     * Updates a single instance of Job Title.
     *
     * @SWG\Patch(
     *     path="/admin/job/titles",
     *     description="This route provides the ability to update a single instance of Job Title.",
     *     tags={"Administration"},
     *     consumes={"application/json"},
     *     summary="Updates a single instance of Employment Status.",
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
     *         name="job_title",
     *         in="body",
     *         required=true,
     *         description="job title object that needs to be updated",
     *         @SWG\Property(ref="#/definitions/JobTitle")
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
     * @param JobTitleRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function update(JobTitleRequest $request)
    {
        return $this->updateModel($request, $this->job_title, ['name', 'description']);
    }
}
