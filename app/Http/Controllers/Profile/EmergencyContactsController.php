<?php namespace HRis\Http\Controllers\Profile;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Exception;
use HRis\EmergencyContact;
use HRis\Employee;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Profile\EmergencyContactsRequest;
use Illuminate\Support\Facades\Redirect;

/**
 * @Middleware("auth")
 */
class EmergencyContactsController extends Controller {

    /**
     * @param Sentry $auth
     * @param Employee $employee
     * @param EmergencyContact $emergencyContact
     */
    public function __construct(Sentry $auth, Employee $employee, EmergencyContact $emergencyContact)
    {
        parent::__construct($auth);

        $this->employee = $employee;
        $this->emergencyContact = $emergencyContact;
    }

    /**
     * Show the Profile - Emergency Contacts.
     *
     * @Get("profile/emergency-contacts")
     * @Get("pim/employee-list/{id}/emergency-contacts")
     *
     * @param EmergencyContactsRequest $request
     * @param null $employee_id
     * @return \Illuminate\View\View
     */
    public function index(EmergencyContactsRequest $request, $employee_id = null)
    {
        $employee = $this->employee->getEmployeeById($employee_id, $this->loggedUser->id);

        if ( ! $employee)
        {
            return Response::make(View::make('errors.404'), 404);
        }

        $this->data['employee'] = $employee;

        $this->data['emergencyContacts'] = $this->emergencyContact->whereEmployeeId($employee->id)->get();

        $this->data['disabled'] = 'disabled';
        $this->data['pim'] = $request->is('*pim/*') ? true : false;
        $this->data['pageTitle'] = $this->data['pim'] ? 'Employee Emergency Contacts' : 'My Emergency Contacts';

        return $this->template('pages.profile.emergency-contacts.view');
    }

    /**
     * Save the Profile - Emergency Contacts.
     *
     * @Post("profile/emergency-contacts")
     * @Post("pim/employee-list/{id}/emergency-contacts")
     *
     * @param EmergencyContactsRequest $request
     */
    public function store(EmergencyContactsRequest $request)
    {
        try
        {
            $this->emergencyContact->create($request->all());

        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to add record to the database.');
        }

        return Redirect::to($request->path())->with('success', 'Record successfully added.');
    }

    /**
     * Update the Profile - Emergency Contacts.
     *
     * @Patch("profile/emergency-contacts")
     * @Patch("pim/employee-list/{id}/emergency-contacts")
     *
     * @param EmergencyContactsRequest $request
     */
    public function update(EmergencyContactsRequest $request)
    {
        $emergencyContact = $this->emergencyContact->whereId($request->get('emergency_contact_id'))->first();

        if ( ! $emergencyContact)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to retrieve record from database.');
        }

        try
        {
            $emergencyContact->update($request->all());

        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to update record.');
        }

        return Redirect::to($request->path())->with('success', 'Record successfully updated.');
    }
}
