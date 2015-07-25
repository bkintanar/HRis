<?php

namespace HRis\Http\Controllers\Administration\Job;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Eloquent\WorkShift;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Administration\WorkShiftRequest;

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
     * @param Sentinel $auth
     * @param WorkShift $work_shift
     */
    public function __construct(Sentinel $auth, WorkShift $work_shift)
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
        $work_shifts = WorkShift::where('id', '>', 0)->get();

        $this->data['table'] = $this->setupDataTable($work_shifts);

        $this->data['pageTitle'] = 'Work Shifts';

        return $this->template('pages.administration.job.work-shift.view');
    }

    /**
     * @return array
     */
    public function setupDataTable($work_shifts)
    {
        $table = [];

        $table['title'] = 'Work Shifts';
        $table['permission'] = 'admin.job.work-shifts';
        $table['headers'] = ['Id', 'Work Shift', 'Duration'];
        $table['model'] = ['singular' => 'work_shift', 'plural' => 'work_shifts', 'dashed' => 'work-shifts'];
        $table['items'] = $work_shifts;

        return $table;
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
            return redirect()->to($request->path())->with('danger', UNABLE_ADD_MESSAGE);
        }

        return redirect()->to($request->path())->with('success', SUCCESS_ADD_MESSAGE);
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
            return redirect()->to($request->path())->with('danger', UNABLE_RETRIEVE_MESSAGE);
        }

        try {
            $work_shift->update($request->all());

        } catch (Exception $e) {
            return redirect()->to($request->path())->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        return redirect()->to($request->path())->with('success', SUCCESS_UPDATE_MESSAGE);
    }
}
