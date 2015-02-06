<?php namespace HRis\Http\Controllers\Profile;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Exception;
use HRis\Dependent;
use HRis\Employee;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Profile\DependentsRequest;
use Illuminate\Support\Facades\Redirect;

/**
 * @Middleware("auth")
 */
class DependentsController extends Controller {

    /**
     * @param Sentry $auth
     * @param Employee $employee
     * @param Dependent $dependent
     */
    public function __construct(Sentry $auth, Employee $employee, Dependent $dependent)
    {
        parent::__construct($auth);

        $this->employee = $employee;
        $this->dependent = $dependent;
    }

    /**
     * Show the Profile - Dependents.
     *
     * @Get("profile/dependents")
     * @Get("pim/employee-list/{id}/dependents")
     *
     * @param DependentsRequest $request
     * @param null $employee_id
     * @return \Illuminate\View\View
     */
    public function index(DependentsRequest $request, $employee_id = null)
    {
        $employee = $this->employee->getEmployeeById($employee_id, $this->loggedUser->id);

        if ( ! $employee)
        {
            return Response::make(View::make('errors.404'), 404);
        }

        $this->data['employee'] = $employee;

        $this->data['dependents'] = $this->dependent->whereEmployeeId($employee->employee_id)->get();

        $this->data['pim'] = $request->is('*pim/*') ? true : false;
        $this->data['pageTitle'] = $this->data['pim'] ? 'Employee Dependents' : 'My Dependents';

        return $this->template('pages.profile.dependents.view');
    }

    /**
     * Save the Profile - Dependents.
     *
     * @Post("profile/dependents")
     * @Post("pim/employee-list/{id}/dependents")
     *
     * @param DependentsRequest $request
     */
    public function store(DependentsRequest $request)
    {
        try
        {
            $this->dependent->create($request->all());

        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to add record to the database.');
        }

        return Redirect::to($request->path())->with('success', 'Record successfully added.');
    }

    /**
     * Update the Profile - Dependents.
     *
     * @Patch("profile/dependents")
     * @Patch("pim/employee-list/{id}/dependents")
     *
     * @param DependentsRequest $request
     */
    public function update(DependentsRequest $request)
    {
        $dependent = $this->dependent->whereId($request->get('dependent_id'))->first();

        if ( ! $dependent)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to retrieve record from database.');
        }

        try
        {
            $dependent->update($request->all());

        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to update record.');
        }

        return Redirect::to($request->path())->with('success', 'Record successfully updated.');
    }
}
