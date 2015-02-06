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

    public function __construct(Sentry $auth, WorkShift $workShift)
    {
        parent::__construct($auth);

        $this->workShift = $workShift;
    }

    /**
     * Show the Administration - Work Shifts.
     *
     * @Get("admin/job/work-shifts")
     *
     * @param WorkShiftRequest $request
     * @return \Illuminate\View\View
     */
    public function workShifts(WorkShiftRequest $request)
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
    public function saveWorkShift(WorkShiftRequest $request)
    {
        try
        {
            $work_shift = new WorkShift;
            $work_shift->name = $request->get('name');
            $work_shift->from_time = $request->get('from_time');
            $work_shift->to_time = $request->get('to_time');
            $work_shift->duration = $request->get('duration');

            $work_shift->save();
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
    public function updateWorkShift(WorkShiftRequest $request)
    {
        $work_shift = $this->workShift->whereId($request->get('work_shift_id'))->first();

        if ( ! $work_shift)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to retrieve record from database.');
        }

        try
        {
            $work_shift->name = $request->get('name');
            $work_shift->from_time = $request->get('from_time');
            $work_shift->to_time = $request->get('to_time');
            $work_shift->duration = $request->get('duration');

            $work_shift->save();
        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to update record.');
        }

        return Redirect::to($request->path())->with('success', 'Record successfully updated.');
    }
}