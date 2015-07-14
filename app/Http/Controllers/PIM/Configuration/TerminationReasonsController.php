<?php

namespace HRis\Http\Controllers\PIM\Configuration;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Eloquent\Employee;
use HRis\Eloquent\TerminationReason;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\PIM\TerminationReasonsRequest;
use Illuminate\Support\Facades\Redirect;

/**
 * Class TerminationReasonsController
 * @package HRis\Http\Controllers\PIM\Configuration
 *
 * @Middleware("auth")
 */
class TerminationReasonsController extends Controller
{

    /**
     * @var Employee
     */
    protected $employee;

    /**
     * @var TerminationReason
     */
    protected $termination_reason;

    /**
     * @param Sentinel $auth
     * @param Employee $employee
     * @param TerminationReason $termination_reason
     */
    public function __construct(Sentinel $auth, Employee $employee, TerminationReason $termination_reason)
    {
        parent::__construct($auth);

        $this->employee = $employee;
        $this->termination_reason = $termination_reason;
    }

    /**
     * Show the PIM - Termination Reasons.
     *
     * @Get("pim/configuration/termination-reasons")
     *
     * @param TerminationReasonsRequest $request
     * @return \Illuminate\View\View
     */
    public function index(TerminationReasonsRequest $request)
    {
        $this->data['employee'] = $this->employee->whereUserId($this->logged_user->id)->first();

        $termination_reasons = $this->termination_reason->get();

        $this->data['table'] = $this->setupDataTable($termination_reasons);

        $this->data['pageTitle'] = 'Termination Reasons';

        return $this->template('pages.pim.configuration.termination-reasons.view');
    }

    /**
     * @return array
     */
    public function setupDataTable($termination_reasons)
    {
        $table = [];

        $table['title'] = 'Termination Reasons';
        $table['permission'] = 'pim.configuration.termination-reasons';
        $table['headers'] = ['Id', 'Name'];
        $table['model'] = [
            'singular' => 'termination_reason',
            'plural'   => 'termination_reasons',
            'dashed'   => 'termination-reasons'
        ];
        $table['items'] = $termination_reasons;

        return $table;
    }

    /**
     * Save the PIM - Termination Reasons.
     *
     * @Post("pim/configuration/termination-reasons")
     *
     * @param TerminationReasonsRequest $request
     */
    public function store(TerminationReasonsRequest $request)
    {
        try {
            $this->termination_reason->create($request->all());

        } catch (Exception $e) {
            return Redirect::to($request->path())->with('danger', UNABLE_ADD_MESSAGE);
        }

        return Redirect::to($request->path())->with('success', 'Record successfully added.');
    }

    /**
     * Update the PIM - Termination Reasons.
     *
     * @Patch("pim/configuration/termination-reasons")
     *
     * @param TerminationReasonsRequest $request
     */
    public function update(TerminationReasonsRequest $request)
    {
        $termination_reason = $this->termination_reason->whereId($request->get('termination_reason_id'))->first();

        if ( ! $termination_reason) {
            return Redirect::to($request->path())->with('danger', UNABLE_RETRIEVE_MESSAGE);
        }

        try {
            $termination_reason->update($request->all());

        } catch (Exception $e) {
            return Redirect::to($request->path())->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        return Redirect::to($request->path())->with('success', SUCCESS_UPDATE_MESSAGE);
    }
}
