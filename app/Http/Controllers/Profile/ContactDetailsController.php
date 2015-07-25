<?php

namespace HRis\Http\Controllers\Profile;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use HRis\Eloquent\Employee;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Profile\ContactDetailsRequest;

/**
 * Class ContactDetailsController
 * @package HRis\Http\Controllers\Profile
 *
 * @Middleware("auth")
 */
class ContactDetailsController extends Controller
{

    /**
     * @var Employee
     */
    protected $employee;

    /**
     * @param Sentinel $auth
     * @param Employee $employee
     */
    public function __construct(Sentinel $auth, Employee $employee)
    {
        parent::__construct($auth);

        $this->employee = $employee;
    }

    /**
     * Show the Profile - Contact Details.
     *
     * @Get("profile/contact-details")
     * @Get("pim/employee-list/{id}/contact-details")
     *
     * @param ContactDetailsRequest $request
     * @param null $employee_id
     *
     * @return \Illuminate\View\View
     */
    public function index(ContactDetailsRequest $request, $employee_id = null)
    {
        $employee = $this->employee->getEmployeeById($employee_id, $this->logged_user->id);

        if ( ! $employee) {
            return response()->make(view()->make('errors.404'), 404);
        }

        $this->data['employee'] = $employee;

        $this->data['disabled'] = 'disabled';
        $this->data['pim'] = $request->is('*pim/*') ? : false;
        $this->data['pageTitle'] = $this->data['pim'] ? 'Employee Contact Details' : 'My Contact Details';

        return $this->template('pages.profile.contact-details.view');
    }

    /**
     * Show the Profile - Contact Details Form.
     *
     * @Get("profile/contact-details/edit")
     * @Get("pim/employee-list/{id}/contact-details/edit")
     *
     * @param ContactDetailsRequest $request
     * @param null $employee_id
     *
     * @return \Illuminate\View\View
     */
    public function show(ContactDetailsRequest $request, $employee_id = null)
    {
        $employee = $this->employee->getEmployeeById($employee_id, $this->logged_user->id);

        if ( ! $employee) {
            return response()->make(view()->make('errors.404'), 404);
        }

        $this->data['employee'] = $employee;

        $this->data['disabled'] = '';
        $this->data['pim'] = $request->is('*pim/*') ? : false;
        $this->data['pageTitle'] = $this->data['pim'] ? 'Edit Employee Contact Details' : 'Edit My Contact Details';

        return $this->template('pages.profile.contact-details.edit');
    }

    /**
     * Updates the Profile - Contact Details.
     *
     * @Patch("profile/contact-details")
     * @Patch("pim/employee-list/{id}/contact-details")
     *
     * @param ContactDetailsRequest $request
     */
    public function update(ContactDetailsRequest $request)
    {
        $id = $request->get('id');

        $employee = $this->employee->whereId($id)->first();

        if ( ! $employee) {
            return redirect()->to($request->path())->with('danger', UNABLE_RETRIEVE_MESSAGE);
        }

        try {
            $employee->update($request->all());

        } catch (Exception $e) {
            return redirect()->to($request->path())->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        return redirect()->to($request->path())->with('success', SUCCESS_UPDATE_MESSAGE);
    }
}
