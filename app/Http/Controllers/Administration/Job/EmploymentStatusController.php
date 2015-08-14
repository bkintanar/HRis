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

    /**
     * @var EmploymentStatus
     */
    protected $employment_status;

    /**
     * @param Sentry $auth
     * @param EmploymentStatus $employment_status
     */
    public function __construct(Sentry $auth, EmploymentStatus $employment_status)
    {
        parent::__construct($auth);

        $this->employment_status = $employment_status;
    }

    /**
     * Show the Administration - Job Employment Status.
     *
     * @Get("admin/job/employment-status")
     *
     * @param EmploymentStatusRequest $request
     *
     * @return \Illuminate\View\View
     */
    public function index(EmploymentStatusRequest $request)
    {
        // TODO:: fix me
        $this->data['employmentStatuses'] = $this->employment_status->where('id', '>', 0)->get();

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
    public function store(EmploymentStatusRequest $request)
    {
        try
        {
            $this->employment_status->create($request->all());

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
    public function update(EmploymentStatusRequest $request)
    {
        $employment_status = $this->employment_status->whereId($request->get('employment_status_id'))->first();

        if ( ! $employment_status)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to retrieve record from database.');
        }

        try
        {
            $employment_status->update($request->all());

        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to update record.');
        }

        return Redirect::to($request->path())->with('success', 'Record successfully updated.');
    }
}
