<?php

namespace HRis\Http\Controllers\Ajax;

use Carbon\Carbon;
use HRis\Eloquent\Timelog;

use Illuminate\Support\Facades\Input;

/**
 * Class AttendanceAjaxController.
 *
 * @Middleware("auth")
 */
class AttendanceAjaxController extends AjaxController
{
    /**
     * Get the server date and time.
     *
     * @Get("ajax/server_time")
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
     * Save time in log in the database.
     *
     * @Post("ajax/time_in")
     *
     * @return Response
     *
     * @author Harlequin Doyon
     */
    public function timeIn()
    {
        try {
            Timelog::create([
                'employee_id' => $this->employee->id,
                'in'          => Carbon::now(),
            ]);
        } catch (Exception $e) {
            abort(404, 'cannot_create_timelog');
        }

        return $this->response(
            'Punch In',
            'You have successfully submitted your timelog.'
        );
    }

    /**
     * Save time out log in the database.
     *
     * @Post("ajax/time_out")
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
