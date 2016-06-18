<?php

/*
 * This file is part of the HRis Software package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @version    alpha
 *
 * @author     Bertrand Kintanar <bertrand.kintanar@gmail.com>
 * @license    BSD License (3-clause)
 * @copyright  (c) 2014-2016, b8 Studios, Ltd
 *
 * @link       http://github.com/HB-Co/HRis
 */

namespace HRis\Api\Controllers\Presence;

use Carbon\Carbon;
use Dingo\Api\Http\Request;
use Exception;
use HRis\Api\Repositories\Time\TimelogRepository;
use Irradiate\Api\Controllers\BaseController;
use Irradiate\Eloquent\Employee;
use Irradiate\Eloquent\Timelog;
use Tymon\JWTAuth\Facades\JWTAuth;

class TimelogController extends BaseController
{
    /**
     * @var TimelogRepository
     */
    public $timelog;

    /**
     * @var Employee
     */
    public $employee;

    /**
     * @var int
     */
    public $rows_per_page = 10;

    /**
     * TimelogController constructor.
     *
     * @param Employee $employee
     */
    public function __construct(Employee $employee)
    {
        $this->timelog = new TimelogRepository();
        $this->employee = $employee;
    }

    /**
     * @param Request $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function index(Request $request)
    {
        $query_params = $request->only('start', 'end', 'offset', 'employee_id');
        $query_params = array_filter($query_params);

        $query_params['offset'] = array_key_exists('offset', $query_params) ?: 0;

        $employee = $this->employee->whereEmployeeId($query_params['employee_id'])->first();

        $start = $this->startOfMonth($query_params);
        $end = $this->endOfMonth($query_params);
        $dateRange = $this->dateRangeFormat($start, $end);
        $timelogs = $this->timelog->range(
            $start->subMinutes($query_params['offset']),
            $end->subMinutes($query_params['offset']),
            $employee->id,
            $this->rows_per_page
        );

        foreach ($query_params as $key => $value) {
            $timelogs->appends($key, $value);
        }

        $data = [
            'timelogs'       => $timelogs,
            'date_range'     => $dateRange,
            'summary_report' => [
                'total_hours' => $this->totalHours($timelogs),
                'late'        => 0,
                'undertime'   => 0,
                'overtime'    => 0,
            ],
        ];

        return $this->responseAPI(200, SUCCESS_RETRIEVE_MESSAGE,
            ['data' => $data, 'table' => $this->setupDataTable($timelogs)]);
    }

    /**
     * @param        $input
     * @param string $format
     *
     * @return static
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    private function startOfMonth($input, $format = 'Y-m-d H:i:s')
    {
        return isset($input['start']) ?
            Carbon::createFromFormat($format, $input['start'].' 00:00:00') :
            Carbon::now()->startOfMonth();
    }

    /**
     * @param        $input
     * @param string $format
     *
     * @return static
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    private function endOfMonth($input, $format = 'Y-m-d H:i:s')
    {
        return isset($input['end']) ?
            Carbon::createFromFormat($format, $input['end'].' 23:59:59') :
            Carbon::now()->endOfMonth();
    }

    /**
     * @param $start
     * @param $end
     *
     * @return string
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    private function dateRangeFormat($start, $end)
    {
        if ($start->month == $end->month &&
            $start->day == 1 &&
            $end->day == $end->format('t')
        ) {
            $this->rows_per_page = cal_days_in_month(CAL_GREGORIAN, $start->month, $start->year);

            return $start->format('F Y');
        } else {
            $this->rows_per_page = $start->diffInDays($end);

            return $start->format('F d, Y').' - '.$end->format('F d, Y');
        }
    }

    /**
     * @param $timelogs
     *
     * @return int
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    private function totalHours($timelogs)
    {
        $total = 0;
        foreach ($timelogs as $timelog) {
            $total += $timelog->rendered_hours;
        }

        return $total;
    }

    /**
     * Setup table for timelogs.
     *
     * @param $timelogs
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    protected function setupDataTable($timelogs)
    {
        $table = [];

        $table['div_size'] = 'col-md-9';
        $table['title'] = 'Timesheet';
        $table['permission'] = '';
        $table['headers'] = ['Date', 'Time In', 'Time Out', 'Hours'];
        $table['model'] = [
            'singular' => 'timelog',
            'plural'   => 'timelogs',
            'dashed'   => 'timelogs',
        ];
        $table['items'] = $timelogs;

        return $table;
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    public function serverTime()
    {
        $server = Carbon::now();

        return $this->responseAPI(200, SUCCESS_RETRIEVE_MESSAGE, ['server' => $server]);
    }

    /**
     * Alert configuration of time in.
     *
     * @return string
     *
     * @author Harlequin Doyon <harlequin.doyon@gmail.com>
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function attemptTimeIn()
    {
        $note = '';

        if (!$this->timelog->hasNoLatestTimein($this->loggedEmployee())) {
            $note = "You have an active timelog that doesn't have a time out yet";
        }

        $data = [
            'title'              => 'Are you sure?',
            'html'               => $this->html('You want to time in!', $note),
            'showCancelButton'   => true,
            'confirmButtonColor' => '#DD6B55',
            'closeOnConfirm'     => false,
        ];

        return $this->responseAPI(200, SUCCESS_RETRIEVE_MESSAGE, $data);
    }

    /**
     * Alert HTML helper.
     *
     * @param string $msg
     * @param string $note
     *
     * @return string
     *
     * @author Harlequin Doyon <harlequin.doyon@gmail.com>
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    private function html($msg, $note = '')
    {
        $output = $msg;
        $output .= '<br>';

        if ($note !== '') {
            $output .= '<span style="font-size:12px" class="text-muted">';
            $output .= 'Note: '.$note;
            $output .= '</span>';
        }

        return $output;
    }

    /**
     * Alert configuration of time out.
     *
     * @return string
     *
     * @author Harlequin Doyon <harlequin.doyon@gmail.com>
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function attemptTimeOut()
    {
        $note = '';

        if (!$this->timelog->hasNoLatestTimeout($this->loggedEmployee())) {
            $note = "You don't have an active time in log";
        }

        $data = [
            'title'              => 'Are you sure?',
            'html'               => $this->html('You want to time out!', $note),
            'showCancelButton'   => true,
            'confirmButtonColor' => '#DD6B55',
            'closeOnConfirm'     => false,
        ];

        return $this->responseAPI(200, SUCCESS_RETRIEVE_MESSAGE, $data);
    }

    /**
     * Save time in log in the database.
     *
     * @param Timelog $timelog
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Harlequin Doyon <harlequin.doyon@gmail.com>
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function timeIn(Timelog $timelog)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $timelog = Timelog::create([
            'employee_id' => $user->employee->id,
            'in'          => Carbon::now(),
        ]);

        $data = [
            'title'      => 'Punch In',
            'text'       => 'You have successfully submitted your timelog.',
            'timelog_id' => $timelog->id,
        ];

        return $this->responseAPI(201, SUCCESS_ADD_MESSAGE, $data);
    }

    /**
     * Save time out log in the database.
     *
     * @param Timelog $timelog
     * @param Request $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Harlequin Doyon <harlequin.doyon@gmail.com>
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function timeOut(Timelog $timelog, Request $request)
    {
        $id = $request->has('id') ? $request->get('id') : null;
        $user = JWTAuth::parseToken()->authenticate();

        try {
            if (is_null($id)) {
                $timelog->create([
                    'employee_id' => $user->employee->id,
                    'out'         => Carbon::now(),
                ]);
            } else {
                $t = $timelog->find($id);
                $t->out = Carbon::now();
                $t->save();
            }
        } catch (Exception $e) {
            abort(404, 'cannot_update_timelog');
        }

        $data = [
            'title' => 'Punch Out',
            'text'  => 'You have successfully submitted your timelog.',
        ];

        return $this->responseAPI(201, SUCCESS_ADD_MESSAGE, $data);
    }
}
