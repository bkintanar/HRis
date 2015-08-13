<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 *
 */

namespace HRis\Http\Controllers\Administration\Job;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Eloquent\EmploymentStatus;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Administration\EmploymentStatusRequest;

/**
 * Class EmploymentStatusController
 * @package HRis\Http\Controllers\Administration\Job
 *
 * @Middleware("auth")
 */
class EmploymentStatusController extends Controller
{
    /**
     * @var EmploymentStatus
     */
    protected $employment_status;

    /**
     * @param Sentinel $auth
     * @param EmploymentStatus $employment_status
     * @author Bertrand Kintanar
     */
    public function __construct(Sentinel $auth, EmploymentStatus $employment_status)
    {
        parent::__construct($auth);

        $this->employment_status = $employment_status;
    }

    /**
     * Show the Administration - Job Employment Status.
     *
     * @Get("admin/job/employment-status")
     *
     * @param EmploymentStatusRequest $request
     * @return \Illuminate\View\View
     * @author Bertrand Kintanar
     */
    public function index(EmploymentStatusRequest $request)
    {
        // TODO:: fix me
        $employment_status = $this->employment_status->where('id', '>', 0)->get();

        $this->data['table'] = $this->setupDataTable($employment_status);
        $this->data['pageTitle'] = 'Employment Status';

        return $this->template('pages.administration.job.employment-status.view');
    }

    /**
     * @param $employment_statuses
     * @return array
     * @author Bertrand Kintanar
     */
    public function setupDataTable($employment_statuses)
    {
        $table = [];

        $table['title'] = 'Employment Status';
        $table['permission'] = 'admin.job.employment-status';
        $table['headers'] = ['Id', 'Name'];
        $table['model'] = [
            'singular' => 'employment_status',
            'plural'   => 'employment_statuses',
            'dashed'   => 'employment-statuses'
        ];
        $table['items'] = $employment_statuses;

        return $table;
    }

    /**
     * Save the Administration - Job Employment Status.
     *
     * @Post("admin/job/employment-status")
     *
     * @param EmploymentStatusRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Bertrand Kintanar
     */
    public function store(EmploymentStatusRequest $request)
    {
        try {
            $this->employment_status->create($request->all());
        } catch (Exception $e) {
            return redirect()->to($request->path())->with('danger', UNABLE_ADD_MESSAGE);
        }

        return redirect()->to($request->path())->with('success', SUCCESS_ADD_MESSAGE);
    }

    /**
     * Update the Administration - Job Employment Status.
     *
     * @Patch("admin/job/employment-status")
     *
     * @param EmploymentStatusRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Bertrand Kintanar
     */
    public function update(EmploymentStatusRequest $request)
    {
        $employment_status = $this->employment_status->whereId($request->get('employment_status_id'))->first();

        if (! $employment_status) {
            return redirect()->to($request->path())->with('danger', UNABLE_RETRIEVE_MESSAGE);
        }

        try {
            $employment_status->update($request->all());
        } catch (Exception $e) {
            return redirect()->to($request->path())->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        return redirect()->to($request->path())->with('success', SUCCESS_UPDATE_MESSAGE);
    }
}
