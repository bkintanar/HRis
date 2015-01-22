<?php namespace HRis\Http\Controllers\Administration\Job;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Administration\JobTitleRequest;
use HRis\JobTitle;
use Illuminate\Support\Facades\Redirect;

/**
 * @Middleware("auth")
 */
class TitleController extends Controller {

    public function __construct(Sentry $auth, JobTitle $jobTitle)
    {
        parent::__construct($auth);

        $this->jobTitle = $jobTitle;
    }

    /**
     * Show the Administration - Job Titles.
     *
     * @Get("admin/job/titles")
     *
     * @param JobTitleRequest $request
     * @return \Illuminate\View\View
     */
    public function titles(JobTitleRequest $request)
    {
        // TODO: fix me
        $this->data['jobTitles'] = JobTitle::all();

        $this->data['pageTitle'] = 'Job Titles';

        return $this->template('pages.administration.job.title.view');
    }

    /**
     * Save the Administration - Job Titles.
     *
     * @Post("admin/job/titles")
     *
     * @param JobTitleRequest $request
     */
    public function saveTitle(JobTitleRequest $request)
    {
        try
        {
            $job_title = new JobTitle;
            $job_title->name = $request->get('name');
            $job_title->description = $request->get('description');

            $job_title->save();
        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to add record to the database.');
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
    public function updateTitle(JobTitleRequest $request)
    {
        $job_title = $this->jobTitle->whereId($request->get('job_title_id'))->first();

        if ( ! $job_title)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to retrieve record from database.');
        }

        try
        {
            $job_title->name = $request->get('name');
            $job_title->description = $request->get('description');

            $job_title->save();
        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to update record.');
        }

        return Redirect::to($request->path())->with('success', 'Record successfully updated.');
    }
}