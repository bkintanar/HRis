<?php namespace HRis\Http\Controllers\Administration\Job;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Administration\WorkShiftRequest;
use HRis\WorkShift;
use Illuminate\Support\Facades\Redirect;

/**
 * @Middleware("auth")
 */
class WorkShiftController extends Controller {

    /**
     * @var WorkShift
     */
    protected $work_shift;

    /**
     * @param Sentry $auth
     * @param WorkShift $work_shift
     */
    public function __construct(Sentry $auth, WorkShift $work_shift)
    {
        parent::__construct($auth);

        $this->work_shift = $work_shift;
    }

    /**
     * Show the Administration - Work Shifts.
     *
     * @Get("admin/job/work-shifts")
     *
     * @param WorkShiftRequest $request
     * @return \Illuminate\View\View
     */
    public function index(WorkShiftRequest $request)
    {
        // TODO: fix me
        $this->data['workShifts'] = WorkShift::where('id', '>', 0)->get();

        $this->data['pageTitle'] = 'Work Shifts';

        return $this->template('pages.administration.job.work-shift.view');
    }

    /**
     * Save the Administration - Work Shifts.
     *
     * @Post("admin/job/work-shifts")
     *
     * @param WorkShiftRequest $request
     */
    public function store(WorkShiftRequest $request)
    {
        try
        {
            $this->work_shift->create($request->all());

        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to add record to the database.');
        }

        return Redirect::to($request->path())->with('success', 'Record successfully added.');
    }

    /**
     * Update the Administration - Work Shifts.
     *
     * @Patch("admin/job/work-shifts")
     *
     * @param WorkShiftRequest $request
     */
    public function update(WorkShiftRequest $request)
    {
        $work_shift = $this->work_shift->whereId($request->get('work_shift_id'))->first();

        if ( ! $work_shift)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to retrieve record from database.');
        }

        try
        {
            $work_shift->update($request->all());

        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to update record.');
        }

        return Redirect::to($request->path())->with('success', 'Record successfully updated.');
    }
}
