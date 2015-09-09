<?php

namespace HRis\Http\Controllers\Ajax;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Repositories\Time\TimelogRepository;
use Illuminate\Http\Request;
use Collective\Html\FormFacade as Form;

/**
 * Class AlertAjaxController.
 *
 * @Middleware("auth")
 */
class AlertAjaxController extends AjaxController
{
    /**
     * Timelog repository.
     *
     * @var Repository
     */
    protected $timelog;

    /**
     * AlertAjaxController contructor.
     *
     * @return void
     *
     * @author Harlequin Doyon
     */
    public function __construct(Sentinel $auth)
    {
        parent::__construct($auth);
        $this->timelog = new TimelogRepository();
    }

    /**
     * Alert configuration of time in.
     *
     * @Get("alert/time-in")
     *
     * @return string
     *
     * @author Harlequin Doyon
     */
    public function timeIn()
    {
        $note = '';

        if (!$this->timelog->hasNoLatestTimein()) {
            $note = 'You have an active timelog that doesn\'t have a time out yet';
        }

        return response()->json([
            'title'              => 'Are you sure?',
            'html'               => $this->html('You want to time in!', $note),
            'showCancelButton'   => true,
            'confirmButtonColor' => '#DD6B55',
            'closeOnConfirm'     => false,
        ]);
    }

    /**
     * Alert configuration of time out.
     *
     * @Get("alert/time-out")
     * 
     * @return string
     *
     * @author Harlequin Doyon
     */
    public function timeOut()
    {
        $note = '';

        if (!$this->timelog->hasNoLatestTimeout()) {
            $note = 'You don\'t have an active time in log';
        }

        return response()->json([
            'title'              => 'Are you sure?',
            'html'               => $this->html('You want to time out!', $note),
            'showCancelButton'   => true,
            'confirmButtonColor' => '#DD6B55',
            'closeOnConfirm'     => false,
        ]);
    }

    /**
     * Timelog delete alert settings
     * @Get("alert/timelog-delete")
     * @return string
     * @author Harlequin Doyon
     */
    public function timelogDelete()
    {
        return response()->json([
            'title' => 'Are you sure?',
            'text' => 'You want to delete this timelog',
            'type' => 'warning',
            'showCancelButton' => true,
            'cancelButtonColor' => '#DD6B55',
            'confirmButtonText' => 'Yes',
            'closeOnConfirm' => false,
        ]);
    }

    /**
     * Timelog edit alert settings
     * @Get("alert/timelog-edit")
     * @return string
     * @author Harlequin Doyon
     */
    public function timelogEdit(Request $request)
    {
        return response()->json([
            'title' => 'Edit timelog',
            'html' => $this->formGroup([
                ['for' => 'time_in', 'title' => 'Time In', 'content' => $request->input('in')],
                ['for' => 'time_out', 'title' => 'Time Out', 'content' => $request->input('out')],
            ]),
            'showCancelButton' => true,
            'closeOnConfirm' => false,
        ]);
    }

    private function formGroup($items)
    {
        $output = '<form class="form-horizontal" style="margin-top:14px">';
        foreach ($items as $item) {
            $output .= '<div class="form-group">';
            $output .= Form::label($item['for'], $item['title'], ['class' => 'col-md-3 control-label']);
            $output .= '<div class="col-md-9">';
            $output .= Form::input('datetime', $item['for'], $item['content'], ['class' => 'form-control', 'placeholder' => $item['title']]);
            $output .= '</div></div>';
        }
        $output .= '</form>';

        return $output;
    }

    /**
     * Alert HTML helper.
     *
     * @param string $msg
     * @param string $note
     *
     * @return string
     *
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
