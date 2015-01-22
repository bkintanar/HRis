<?php namespace HRis\Http\Controllers\PIM\Configuration;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use HRis\Employee;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\PIM\TerminationReasonsRequest;
use HRis\TerminationReason;
use Illuminate\Support\Facades\Redirect;

/**
 * @Middleware("auth")
 */
class TerminationReasonsController extends Controller {

    public function __construct(Sentry $auth, Employee $employee, TerminationReason $terminationReason)
    {
        parent::__construct($auth);

        $this->employee = $employee;
        $this->terminationReasons = $terminationReason;
    }

    /**
     * Show the PIM - Termination Reasons.
     *
     * @Get("pim/configuration/termination-reasons")
     * @param TerminationReasonsRequest $request
     * @return \Illuminate\View\View
     */
    public function terminationReasons(TerminationReasonsRequest $request)
    {
        $this->data['employee'] = $this->employee->whereUserId($this->loggedUser->id)->first();
        $this->data['terminationReasons'] = $this->terminationReasons->get();

        $this->data['pageTitle'] = 'Termination Reasons';

        return $this->template('pages.pim.configuration.termination-reasons.view');
    }

    /**
     * Save the PIM - Termination Reasons.
     *
     * @Post("pim/configuration/termination-reasons")
     *
     * @param TerminationReasonsRequest $request
     */
    public function saveTerminationReason(TerminationReasonsRequest $request)
    {
        try
        {
            $termination_reason = new TerminationReason;
            $termination_reason->name = $request->get('name');

            $termination_reason->save();
        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to add record to the database.');
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
    public function updateTerminationReason(TerminationReasonsRequest $request)
    {
        $termination_reason = $this->terminationReasons->whereId($request->get('termination_reason_id'))->first();

        if ( ! $termination_reason)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to retrieve record from database.');
        }

        try
        {
            $termination_reason->name = $request->get('name');

            $termination_reason->save();
        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to update record.');
        }

        return Redirect::to($request->path())->with('success', 'Record successfully updated.');
    }
}
