<?php namespace HRis\Http\Controllers\Administration\Job;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use HRis\EmploymentStatus;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Administration\EmploymentStatusRequest;
use Illuminate\Support\Facades\Redirect;

/**
 * @Middleware("auth")
 */
class EmploymentStatusController extends Controller {

    public function __construct(Sentry $auth, EmploymentStatus $employmentStatus)
    {
        parent::__construct($auth);

        $this->employmentStatus = $employmentStatus;
    }

    /**
     * Show the Administration - Job Employment Status.
     *
     * @Get("admin/job/employment-status")
     *
     * @param EmploymentStatusRequest $request
     * @return \Illuminate\View\View
     */
    public function employmentStatus(EmploymentStatusRequest $request)
    {
        // TODO:: fix me
        $this->data['employmentStatuses'] = EmploymentStatus::where('id', '>', 0)->get();

        $this->data['pageTitle'] = 'Employment Status';

        return $this->template('pages.administration.job.employment-status.view');
    }

    /**
     * Save the Administration - Job Employment Status.
     *
     * @Post("admin/job/employment-status")
     *
     * @param EmploymentStatusRequest $request
     */
    public function saveEmploymentStatus(EmploymentStatusRequest $request)
    {
        try
        {
            $employment_status = new EmploymentStatus;
            $employment_status->name = $request->get('name');
            $employment_status->class = $request->get('class');

            $employment_status->save();
        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to add record to the database.');
        }

        return Redirect::to($request->path())->with('success', 'Record successfully added.');
    }

    /**
     * Update the Administration - Job Employment Status.
     *
     * @Patch("admin/job/employment-status")
     *
     * @param EmploymentStatusRequest $request
     */
    public function updateEmploymentStatus(EmploymentStatusRequest $request)
    {
        $employment_status = $this->employmentStatus->whereId($request->get('employment_status_id'))->first();

        if ( ! $employment_status)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to retrieve record from database.');
        }

        try
        {
            $employment_status->name = $request->get('name');
            $employment_status->class = $request->get('class');

            $employment_status->save();
        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to update record.');
        }

        return Redirect::to($request->path())->with('success', 'Record successfully updated.');
    }
}