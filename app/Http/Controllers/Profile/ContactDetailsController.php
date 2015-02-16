<?php namespace HRis\Http\Controllers\Profile;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Exception;
use HRis\Employee;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Profile\ContactDetailsRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

/**
 * @Middleware("auth")
 */
class ContactDetailsController extends Controller {

    /**
     * @var Employee
     */
    protected $employee;

    /**
     * @param Sentry $auth
     * @param Employee $employee
     */
    public function __construct(Sentry $auth, Employee $employee)
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
        $employee = $this->employee->getEmployeeById($employee_id, $this->loggedUser->id);

        if ( ! $employee)
        {
            return Response::make(View::make('errors.404'), 404);
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
        $employee = $this->employee->getEmployeeById($employee_id, $this->loggedUser->id);

        if ( ! $employee)
        {
            return Response::make(View::make('errors.404'), 404);
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

        if ( ! $employee)
        {
            return Redirect::to($request->path())->with('danger', UNABLE_RETRIEVE_MESSAGE);
        }

        try
        {
            $employee->update($request->all());

        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        return Redirect::to($request->path())->with('success', SUCCESS_UPDATE_MESSAGE);
    }
}
