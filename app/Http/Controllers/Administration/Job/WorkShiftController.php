<?php

namespace HRis\Http\Controllers\Administration\Job;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use HRis\Eloquent\WorkShift;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Administration\WorkShiftRequest;
use Illuminate\Support\Facades\Redirect;

/**
 * Class WorkShiftController
 * @package HRis\Http\Controllers\Administration\Job
 *
 * @Middleware("auth")
 */
class WorkShiftController extends Controller
{

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
        try {
            $this->work_shift->create($request->all());

        } catch (Exception $e) {
            return Redirect::to($request->path())->with('danger', UNABLE_ADD_MESSAGE);
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

        if ( ! $work_shift) {
            return Redirect::to($request->path())->with('danger', UNABLE_RETRIEVE_MESSAGE);
        }

        try {
            $work_shift->update($request->all());

        } catch (Exception $e) {
            return Redirect::to($request->path())->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        return Redirect::to($request->path())->with('success', 'Record successfully updated.');
    }
}
