<?php

namespace HRis\Http\Controllers\Ajax;

use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Eloquent\Timelog;
use HRis\Repositories\Time\TimelogRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

/**
 * Class AttendanceAjaxController.
 *
 * @Middleware("auth")
 */
class AttendanceAjaxController extends AjaxController
{
    protected $timelog;

    public function __construct(Sentinel $auth)
    {
        parent::__construct($auth);
        $this->timelog = new TimelogRepository();
    }

    /**
     * Get the server date and time.
     *
     * @Get("ajax/server-time")
     *
     * @return string
     *
     * @author Harlequin Doyon
     */
    public function serverTime()
    {
        return response()->json([
            'server' => \Carbon\Carbon::now(),
        ]);
    }

    /**
     * Get timelogs.
     *
     * @Get("ajax/timelogs")
     *
     * @return string
     *
     * @author Harlequin Doyon
     */
    public function timelogs(Request $request)
    {
        $input = $request->only('start', 'end', 'offset');
        $format = 'Y-m-d H:i:s';
        $start = $this->startOfMonth($input);
        $end = $this->endOfMonth($input);
        $dateRange = $this->dateRangeFormat($start, $end);
        $timelogs = $this->timelog->range(
                $start->subMinutes($input['offset']),
                $end->subMinutes($input['offset'])
            );

        return response()->json([
            'timelogs'       => $timelogs,
            'date_range'     => $dateRange,
            'summary_report' => [
                'total_hours' => $this->totalHours($timelogs),
                'late'        => 0,
                'undertime'   => 0,
                'overtime'    => 0,
            ],
        ]);
    }

    /**
     * Update timelog.
     *
     * @Put("ajax/timelog/{id}")
     *
     * @param int     $id
     * @param Request $request
     *
     * @return Timelog
     *
     * @author Harlequin Doyon
     */
    public function updateTimelog($id, Request $request)
    {
        $timelog = Timelog::find($id);
        $timelog->in = Carbon::createFromFormat('Y-m-d H:i', $request->input('in'));
        $timelog->out = Carbon::createFromFormat('Y-m-d H:i', $request->input('out'));
        $timelog->save();

        return $this->response(
            'Updated!',
            'Timelog successfully updated.', [
                'rendered_hours' => $timelog->rendered_hours,
            ]
        );
    }

    /**
     * @Delete("ajax/timelog/{id}")
     *
     * @param int $id
     *
     * @return string
     *
     * @author Harlequin Doyon
     */
    public function destroyTimelog($id)
    {
        Timelog::destroy($id);

        return $this->response(
            'Deleted!',
            'Timelog successfully deleted.'
        );
    }

    private function startOfMonth($input, $format = 'Y-m-d H:i:s')
    {
        return isset($input['start']) ?
            Carbon::createFromFormat($format, $input['start'].' 00:00:00') :
            Carbon::now()->startOfMonth();
    }

    private function endOfMonth($input, $format = 'Y-m-d H:i:s')
    {
        return isset($input['end']) ?
            Carbon::createFromFormat($format, $input['end'].' 23:59:59') :
            Carbon::now()->endOfMonth();
    }

    private function totalHours($timelogs)
    {
        $total = 0;
        foreach ($timelogs as $timelog) {
            $total += $timelog->rendered_hours;
        }

        return $total;
    }

    private function dateRangeFormat($start, $end)
    {
        if ($start->month == $end->month &&
            $start->day == 1 &&
            $end->day == $end->format('t')) {
            return $start->format('F Y');
        } else {
            return $start->format('F d, Y').' - '.$end->format('F d, Y');
        }
    }

    /**
     * Save time in log in the database.
     *
     * @Post("ajax/time-in")
     *
     * @return Response
     *
     * @author Harlequin Doyon
     */
    public function timeIn()
    {
        try {
            $timelog = Timelog::create([
                'employee_id' => $this->employee->id,
                'in'          => Carbon::now(),
            ]);
        } catch (Exception $e) {
            abort(404, 'cannot_create_timelog');
        }

        return $this->response(
            'Punch In',
            'You have successfully submitted your timelog.',
            ['timelog_id' => $timelog->id]
        );
    }

    /**
     * Save time out log in the database.
     *
     * @Post("ajax/time-out")
     *
     * @param int $timelogId
     *
     * @return Response
     *
     * @author Harlequin Doyon
     */
    public function timeOut()
    {
        $id = Input::get('id');
        try {
            if (is_null($id)) {
                Timelog::create([
                    'employee_id' => $this->employee->id,
                    'out'         => Carbon::now(),
                ]);
            } else {
                $timelog = Timelog::find($id);
                $timelog->out = Carbon::now();
                $timelog->save();
            }
        } catch (Exception $e) {
            abort(404, 'cannot_update_timelog');
        }

        return $this->response(
            'Punch Out',
            'You have successfully submitted your timelog.'
        ); // HTTP OK
    }
}
