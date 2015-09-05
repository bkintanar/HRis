<?php

namespace HRis\Http\Controllers\Time\Attendance;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Eloquent\Timelog;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests;
use HRis\Http\Requests\Time\Attendance\AttendanceRequest;
use Illuminate\Http\Request;
use HRis\Repositories\Time\TimelogRepository;

/**
 * Class AttendanceController.
 *
 * @Middleware("auth")
 */
class AttendanceController extends Controller
{
    /**
     * Sentinel authentication
     * @var Sentinel
     */
    public $auth;

    /**
     * Current Employee
     * @var Employee
     */
    protected $employee;

    /**
     * Timelog Repository
     * @var Timelog
     */
    protected $timelog;

    /**
     * Attendance Controller
     * 
     * @param Sentinel $auth
     * @author Harlequin Doyon
     */
    public function __construct(Sentinel $auth)
    {
        parent::__construct($auth);

        if ($this->auth) {
            $this->employee = $this->auth->employee;
        }
        
        $this->initRepositories();
    }

    /**
     * Initialize repositories
     * @return void
     */
    public function initRepositories()
    {
        $this->timelog = new TimelogRepository();
    }

    /**
     * Display a listing of attendance.
     *
     * @Get("presence")
     *
     * @return Response
     * @author Harlequin Doyon
     */
    public function index(AttendanceRequest $request)
    {
        $latest = $this->timelog->latest();

        $this->data([
            'pageTitle' => 'My Presence',
            'timelogs'  => $this->timelog->paginate($this->employee->id),
            'settings'  => $request->paginationSettings(),
            'latest'    => is_null($latest->out) ? $latest : null,
        ]);

        return $this->template('pages.time.attendance.index');
    }

    /**
     * Show the form for creating a new timelog.
     *
     * @Get("presence/compose")
     * @return Response
     * @author Harlequin Doyon
     */
    public function create()
    {
        return $this->template('pages.time.attendance.create');
    }

    /**
     * Store a newly created timelog in storage.
     *
     * @Post("presence/compose")
     * @param  Request  $request
     * @return Response
     * @author Harlequin Doyon
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified timelog.
     *
     * @Get("presence/{id}")
     * @param  int  $id
     * @return Response
     * @author Harlequin Doyon
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified timelog.
     *
     * @Get("presence/{id}/edit")
     * @param  int  $id
     * @return Response
     * @author Harlequin Doyon
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified timelog in storage.
     *
     * @Patch("presence/{id}")
     * 
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     * @author Harlequin Doyon
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified timelog from storage.
     *
     * @Delete("presence/{id}")
     * 
     * @param  int  $id
     * @return Response
     * @author Harlequin Doyon
     */
    public function destroy($id)
    {
        //
    }
}
