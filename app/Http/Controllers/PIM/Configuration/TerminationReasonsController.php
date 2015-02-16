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

    /**
     * @var Employee
     */
    protected $employee;

    /**
     * @var TerminationReason
     */
    protected $termination_reason;

    /**
     * @param Sentry $auth
     * @param Employee $employee
     * @param TerminationReason $termination_reason
     */
    public function __construct(Sentry $auth, Employee $employee, TerminationReason $termination_reason)
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
        $this->data['employee'] = $this->employee->whereUserId($this->loggedUser->id)->first();
        $this->data['terminationReasons'] = $this->termination_reason->get();
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
    public function store(TerminationReasonsRequest $request)
    {
        try
        {
            $this->termination_reason->create($request->all());

        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', UNABLE_ADD_MESSAGE);
        }

        return Redirect::to($request->path())->with('success', SUCCESS_ADD_MESSAGE);
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

        if ( ! $termination_reason)
        {
            return Redirect::to($request->path())->with('danger', UNABLE_RETRIEVE_MESSAGE);
        }

        try
        {
            $termination_reason->update($request->all());

        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        return Redirect::to($request->path())->with('success', SUCCESS_UPDATE_MESSAGEW);
    }
}
