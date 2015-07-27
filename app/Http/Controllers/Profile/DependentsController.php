<?php

namespace HRis\Http\Controllers\Profile;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use HRis\Eloquent\Dependent;
use HRis\Eloquent\Employee;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Profile\DependentsRequest;
use Illuminate\Support\Facades\Request;

/**
 * Class DependentsController
 * @package HRis\Http\Controllers\Profile
 *
 * @Middleware("auth")
 */
class DependentsController extends Controller
{

    /**
     * @var Dependent
     */
    protected $dependent;

    /**
     * @var Employee
     */
    protected $employee;

    /**
     * @param Sentinel $auth
     * @param Employee $employee
     * @param Dependent $dependent
     */
    public function __construct(Sentinel $auth, Employee $employee, Dependent $dependent)
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
        $employee = $this->employee->getEmployeeById($employee_id, $this->logged_user->id);

        if ( ! $employee) {
            return response()->make(view()->make('errors.404'), 404);
        }

        $this->data['employee'] = $employee;

        $dependents = $this->dependent->whereEmployeeId($employee->id)->get();

        $this->data['pim'] = $request->is('*pim/*') ? : false;
        $this->data['table'] = $this->setupDataTable($dependents);
        $this->data['pageTitle'] = $this->data['pim'] ? 'Employee Dependents' : 'My Dependents';

        return $this->template('pages.profile.dependents.view');
    }

    /**
     * @return array
     */
    public function setupDataTable($dependents)
    {
        $table = [];

        $table['title'] = 'Assigned Dependents';
        $table['permission'] = str_replace('pim', 'profile', Request::segment(1)) . '.dependents';
        $table['headers'] = ['Full Name', 'Relationship', 'Birth Date'];
        $table['model'] = ['singular' => 'dependent', 'plural' => 'dependents', 'dashed' => 'dependents'];
        $table['items'] = $dependents;

        return $table;
    }

    /**
     * Save the Profile - Dependents.
     *
     * @Post("profile/dependents")
     * @Post("pim/employee-list/{id}/dependents")
     *
     * @param DependentsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DependentsRequest $request)
    {
        try {
            $this->dependent->create($request->all());
        } catch (Exception $e) {
            return redirect()->to($request->path())->with('danger', UNABLE_ADD_MESSAGE);
        }

        return redirect()->to($request->path())->with('success', SUCCESS_ADD_MESSAGE);
    }

    /**
     * Update the Profile - Dependents.
     *
     * @Patch("profile/dependents")
     * @Patch("pim/employee-list/{id}/dependents")
     *
     * @param DependentsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(DependentsRequest $request)
    {
        $dependent = $this->dependent->whereId($request->get('dependent_id'))->first();

        if ( ! $dependent) {
            return redirect()->to($request->path())->with('danger', 'Unable to retrieve record from database.');
        }

        try {
            $dependent->update($request->all());
        } catch (Exception $e) {
            return redirect()->to($request->path())->with('danger', 'Unable to update record.');
        }

        return redirect()->to($request->path())->with('success', 'Record successfully updated.');
    }

    /**
     * Delete the profile dependent.
     *
     * @Delete("ajax/profile/dependents")
     * @Delete("ajax/pim/employee-list/{id}/dependents")
     *
     * @param DependentsRequest $request
     */
    public function deleteDependent(DependentsRequest $request)
    {
        if ($request->ajax()) {
            $dependentId = $request->get('id');

            try {
                $this->dependent->whereId($dependentId)->delete();

                print('success');
            } catch (Exception $e) {
                print('failed');
            }
        }
    }

    /**
     * Get the profile dependent.
     *
     * @Get("ajax/profile/dependents")
     * @Get("ajax/pim/employee-list/{id}/dependents")
     *
     * @param DependentsRequest $request
     */
    public function getDependent(DependentsRequest $request)
    {
        if ($request->ajax()) {
            $dependentId = $request->get('id');

            try {
                $dependent = $this->dependent->whereId($dependentId)->first();

                print(json_encode($dependent));
            } catch (Exception $e) {
                print('failed');
            }

        }
    }
}
