<?php

namespace HRis\Http\Controllers\Time;

use HRis\Http\Controllers\Controller;

/**
 * @Middleware("auth")
 */
class RequisitionController extends Controller 
{
    /**
     * Display a listing of requisition.
     * @Get("time/requisition")
     * @return Response
     * @author Harlequin Doyon
     */
    public function index()
    {
        $this->data([
            'pageTitle' => 'Requisition',
        ]);

        return $this->template('pages.time.requisition.index');
    }
}