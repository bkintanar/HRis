<?php

namespace HRis\Http\Controllers\Ajax;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Http\Controllers\Controller;
use HRis\Repositories\Time\TimelogRepository;

/**
 * Class AlertAjaxController.
 *
 * @Middleware("auth")
 */
class AlertAjaxController extends AjaxController
{
    /**
     * Timelog repository
     * @var Repository
     */
    protected $timelog;

    /**
     * AlertAjaxController contructor
     * @return void
     * @author Harlequin Doyon
     */
    public function __construct(Sentinel $auth)
    {
        parent::__construct($auth);
        $this->timelog = new TimelogRepository();
    }

    /**
     * Alert configuration of time in
     *
     * @Get("alert/time_in")
     * @return string
     * @author Harlequin Doyon
     */
    public function timeIn()
    {
        $note = '';

        if (! $this->timelog->hasNoLatestTimein()) {
            $note = 'You have an active timelog that doesn\'t have a time in yet';
        }

        return response()->json([
            'title' => 'Are you sure?',
            'html' => $this->html('You want to time in!', $note),
            'showCancelButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'closeOnConfirm' => false,
        ]);
    }

    /**
     * Alert configuration of time out
     *
     * @Get("alert/time_out")
     * 
     * @return string
     * @author Harlequin Doyon
     */
    public function timeOut()
    {
        $note = '';

        if (! $this->timelog->hasNoLatestTimeout()) {
            $note = 'You don\'t have an active time in log';
        }

        return response()->json([
            'title' => 'Are you sure?',
            'html' => $this->html('You want to time out!', $note),
            'showCancelButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'closeOnConfirm' => false,
        ]);
    }

    /**
     * Alert HTML helper
     * @param  string $msg
     * @param  string $note
     * @return string
     * @author Harlequin Doyon
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
}
