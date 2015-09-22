<?php

namespace HRis\Http\Controllers\Time;

use Illuminate\Http\Request;

use HRis\Http\Requests;
use HRis\Http\Controllers\Controller;

/**
 * @Middleware("auth")
 */
class HolidaysAndEventsController extends Controller
{
    /**
     * Display a listing of the holidays and events.
     *
     * @Get("time/holidays-and-events")
     * @return Response
     * @author Harlequin Doyon
     */
    public function index()
    {
        $this->data([
            'pageTitle' => 'Holidays and Events',
        ]);

        return $this->template('pages.time.holidays_and_events.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
