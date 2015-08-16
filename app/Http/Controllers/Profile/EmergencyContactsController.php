<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Http\Controllers\Profile;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use HRis\Eloquent\CustomFieldSection;
use HRis\Eloquent\CustomFieldValue;
use HRis\Eloquent\EmergencyContact;
use HRis\Eloquent\Employee;
use HRis\Eloquent\Navlink;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Profile\EmergencyContactsRequest;
use Illuminate\Support\Facades\Request;

/**
 * Class EmergencyContactsController.
 *
 * @Middleware("auth")
 */
class EmergencyContactsController extends Controller
{
    /**
     * @var Employee
     */
    protected $employee;

    /**
     * @var EmergencyContact
     */
    protected $emergency_contact;

    /**
     * @var CustomFieldValue
     */
    protected $custom_field_value;

    /**
     * @param Sentinel         $auth
     * @param Employee         $employee
     * @param EmergencyContact $emergency_contact
     * @param CustomFieldValue $custom_field_value
     *
     * @author Bertrand Kintanar
     */
    public function __construct(Sentinel $auth, Employee $employee, EmergencyContact $emergency_contact, CustomFieldValue $custom_field_value)
    {
        parent::__construct($auth);

        $this->employee = $employee;
        $this->emergency_contact = $emergency_contact;
        $this->custom_field_value = $custom_field_value;

        $profile_details_id = Navlink::whereName('Emergency Contacts')->pluck('id');
        $this->data['custom_field_sections'] = CustomFieldSection::whereScreenId($profile_details_id)->get();
    }

    /**
     * Show the Profile - Emergency Contacts.
     *
     * @Get("pim/employee-list/{id}/emergency-contacts")
     * @Get("profile/emergency-contacts")
     *
     * @param EmergencyContactsRequest $request
     * @param null                     $employee_id
     *
     * @return \Illuminate\View\View
     *
     * @author Bertrand Kintanar
     */
    public function index(EmergencyContactsRequest $request, $employee_id = null)
    {
        $employee = $this->employee->getEmployeeById($employee_id, $this->logged_user->id);

        if (!$employee) {
            return response()->make(view()->make('errors.404'), 404);
        }

        $this->data['employee'] = $employee;

        $emergency_contacts = $this->emergency_contact->whereEmployeeId($employee->id)->get();
        $custom_field_values = $this->custom_field_value->whereEmployeeId($employee->id)->lists('value',
            'pim_custom_field_id');

        $this->data['disabled'] = 'disabled';
        $this->data['custom_field_values'] = count($custom_field_values) ? $custom_field_values : null;
        $this->data['pim'] = $request->is('*pim/*') ?: false;
        $this->data['table'] = $this->setupDataTable($emergency_contacts);
        $this->data['pageTitle'] = $this->data['pim'] ? 'Employee Emergency Contacts' : 'My Emergency Contacts';

        return $this->template('pages.profile.emergency-contacts.view');
    }

    /**
     * Edit the Profile - Emergency Contacts.
     *
     * @Get("pim/employee-list/{id}/emergency-contacts/edit")
     * @Get("profile/emergency-contacts/edit")
     *
     * @param Request $request
     * @param null    $employee_id
     *
     * @author Bertrand Kintanar
     */
    public function edit(Request $request, $employee_id = null)
    {
    }

    /**
     * @param $emergency_contacts
     *
     * @return array
     *
     * @author Bertrand Kintanar
     */
    public function setupDataTable($emergency_contacts)
    {
        $table = [];

        $table['title'] = 'In case of Emergency';
        $table['permission'] = str_replace('pim', 'profile', Request::segment(1)).'.emergency-contacts';
        $table['headers'] = ['Full Name', 'Relationship', 'Home Telephone', 'Mobile'];
        $table['model'] = [
            'singular' => 'emergency_contact',
            'plural'   => 'emergency_contacts',
            'dashed'   => 'emergency-contacts',
        ];
        $table['items'] = $emergency_contacts;

        return $table;
    }

    /**
     * Save the Profile - Emergency Contacts.
     *
     * @Post("profile/emergency-contacts")
     * @Post("pim/employee-list/{id}/emergency-contacts")
     *
     * @param EmergencyContactsRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar
     */
    public function store(EmergencyContactsRequest $request)
    {
        try {
            $this->emergencyContact->create($request->all());
        } catch (Exception $e) {
            return redirect()->to($request->path())->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        return redirect()->to($request->path())->with('success', SUCCESS_ADD_MESSAGE);
    }

    /**
     * Update the Profile - Emergency Contacts.
     *
     * @Patch("profile/emergency-contacts")
     * @Patch("pim/employee-list/{id}/emergency-contacts")
     *
     * @param EmergencyContactsRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar
     */
    public function update(EmergencyContactsRequest $request)
    {
        $emergency_contact = $this->emergencyContact->whereId($request->get('emergency_contact_id'))->first();

        if (!$emergency_contact) {
            return redirect()->to($request->path())->with('danger', UNABLE_RETRIEVE_MESSAGE);
        }

        try {
            $emergency_contact->update($request->all());
        } catch (Exception $e) {
            return redirect()->to($request->path())->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        return redirect()->to($request->path())->with('success', SUCCESS_UPDATE_MESSAGE);
    }

    /**
     * Delete the profile emergency contact.
     *
     * @Delete("ajax/profile/emergency-contacts")
     * @Delete("ajax/pim/employee-list/{id}/emergency-contacts")
     *
     * @param EmergencyContactsRequest $request
     *
     * @author Bertrand Kintanar
     */
    public function delete(EmergencyContactsRequest $request)
    {
        if ($request->ajax()) {
            $emergency_contact_id = $request->get('id');

            try {
                $this->emergencyContact->whereId($emergency_contact_id)->delete();

                print('success');
            } catch (Exception $e) {
                print('failed');
            }
        }
    }

    /**
     * Get the profile emergency contact.
     *
     * @Get("ajax/profile/emergency-contacts")
     * @Get("ajax/pim/employee-list/{id}/emergency-contacts")
     *
     * @param EmergencyContactsRequest $request
     *
     * @author Bertrand Kintanar
     */
    public function show(EmergencyContactsRequest $request)
    {
        if ($request->ajax()) {
            $emergency_contact_id = $request->get('id');

            try {
                $emergency_contact = $this->emergencyContact->whereId($emergency_contact_id)->first();

                print(json_encode($emergency_contact));
            } catch (Exception $e) {
                print('failed');
            }
        }
    }
}
