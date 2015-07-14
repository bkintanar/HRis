<?php

namespace HRis\Http\Controllers\Administration\Job;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Eloquent\JobTitle;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Administration\JobTitleRequest;
use Illuminate\Support\Facades\Redirect;

/**
 * Class TitleController
 * @package HRis\Http\Controllers\Administration\Job
 *
 * @Middleware("auth")
 */
class TitleController extends Controller
{

    /**
     * @var JobTitle
     */
    protected $job_title;

    /**
     * @param Sentinel $auth
     * @param JobTitle $job_title
     */
    public function __construct(Sentinel $auth, JobTitle $job_title)
    {
        parent::__construct($auth);

        $this->job_title = $job_title;
    }

    /**
     * Show the Administration - Job Titles.
     *
     * @Get("admin/job/titles")
     *
     * @param JobTitleRequest $request
     * @return \Illuminate\View\View
     */
    public function index(JobTitleRequest $request)
    {
        // TODO: fix me
        $job_titles = JobTitle::where('id', '>', 0)->get();

        $this->data['table'] = $this->setupDataTable($job_titles);

        $this->data['pageTitle'] = 'Job Titles';

        return $this->template('pages.administration.job.title.view');
    }

    /**
     * @return array
     */
    public function setupDataTable($job_titles)
    {
        $table = [];

        $table['title'] = 'Job Titles';
        $table['permission'] = 'admin.job.titles';
        $table['headers'] = ['Id', 'Job Title', 'Job Description'];
        $table['model'] = ['singular' => 'job_title', 'plural' => 'job_titles', 'dashed' => 'job-titles'];
        $table['items'] = $job_titles;

        return $table;
    }

    /**
     * Save the Administration - Job Titles.
     *
     * @Post("admin/job/titles")
     *
     * @param JobTitleRequest $request
     */
    public function store(JobTitleRequest $request)
    {
        try {
            $this->job_title->create($request->all());

        } catch (Exception $e) {
            return Redirect::to($request->path())->with('danger', UNABLE_ADD_MESSAGE);
        }

        return Redirect::to($request->path())->with('success', 'Record successfully added.');
    }

    /**
     * Update the Administration - Job Titles.
     *
     * @Patch("admin/job/titles")
     *
     * @param JobTitleRequest $request
     */
    public function update(JobTitleRequest $request)
    {
        $job_title = $this->job_title->whereId($request->get('job_title_id'))->first();

        if ( ! $job_title) {
            return Redirect::to($request->path())->with('danger', UNABLE_RETRIEVE_MESSAGE);
        }

        try {
            $job_title->update($request->all());

        } catch (Exception $e) {
            return Redirect::to($request->path())->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        return Redirect::to($request->path())->with('success', 'Record successfully updated.');
    }
}
