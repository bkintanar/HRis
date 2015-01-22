<?php namespace HRis\Http\Controllers\Profile;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Exception;
use HRis\Employee;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Profile\ContactDetailsRequest;
use Illuminate\Support\Facades\Redirect;

/**
 * @Middleware("auth")
 */
class ContactDetailsController extends Controller {

    protected $employee;

    protected $user;

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
     * @return \Illuminate\View\View
     */
    public function contactDetails(ContactDetailsRequest $request, $employee_id = null)
    {
        $employee = $this->employee->getEmployeeById($employee_id, $this->loggedUser->id);

        if ( ! $employee)
        {
            return Response::make(View::make('errors.404'), 404);
        }

        $this->data['employee'] = $employee;

        $this->data['disabled'] = 'disabled';
        $this->data['pim'] = $request->is('*pim/*') ? true : false;
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
     * @return \Illuminate\View\View
     */
    public function showContactDetailsEditForm(ContactDetailsRequest $request, $employee_id = null)
    {
        $employee = $this->employee->getEmployeeById($employee_id, $this->loggedUser->id);

        if ( ! $employee)
        {
            return Response::make(View::make('errors.404'), 404);
        }

        $this->data['employee'] = $employee;

        $this->data['disabled'] = '';
        $this->data['pim'] = $request->is('*pim/*') ? true : false;
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
    public function updateContactDetails(ContactDetailsRequest $request)
    {
        $id = $request->get('id');

        $employee = $this->employee->whereId($id)->first();

        if ( ! $employee)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to retrieve record from database.');
        }

        try
        {
            $employee->address_1 = $request->get('address_1');
            $employee->address_2 = $request->get('address_2');
            $employee->address_city_id = $request->get('address_city_id');
            $employee->address_province_id = $request->get('address_province_id');
            $employee->address_country_id = $request->get('address_country_id');
            $employee->address_postal_code = $request->get('address_postal_code');
            $employee->home_phone = $request->get('home_phone');
            $employee->mobile_phone = $request->get('mobile_phone');
            $employee->work_email = $request->get('work_email');
            $employee->other_email = $request->get('other_email');

            $employee->save();
        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to update record.');
        }

        return Redirect::to($request->path())->with('success', 'Record successfully updated.');
    }
}
