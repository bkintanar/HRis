<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Api\Controllers\Profile;

use HRis\Api\Controllers\BaseController;
use HRis\Api\Controllers\Controller;
use HRis\Api\Eloquent\EmergencyContact;
use HRis\Api\Eloquent\Employee;
use HRis\Api\Requests\Profile\EmergencyContactsRequest;

class EmergencyContactsController extends BaseController
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
     * @param Employee         $employee
     * @param EmergencyContact $emergency_contact
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function __construct(Employee $employee, EmergencyContact $emergency_contact)
    {
        $this->middleware('jwt.auth');

        $this->employee = $employee;
        $this->emergency_contact = $emergency_contact;
    }

    /**
     * Show the Profile - Emergency Contacts.
     *
     * @param EmergencyContactsRequest $request
     *
     * @return \Illuminate\View\View
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function index(EmergencyContactsRequest $request)
    {
        $employee = $this->employee->getEmployeeById($request->get('employee_id'), null);

        // TODO: recode this
        if (!$employee) {
            return response()->make(view()->make('errors.404'), 404);
        }

        return $this->xhr($employee);
    }

    /**
     * Save the Profile - Emergency Contacts.
     *
     * @param EmergencyContactsRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function store(EmergencyContactsRequest $request)
    {
        try {
            $attributes = array_filter($request->except('relationships', 'relationship'));
            $emergency_contact = $this->emergency_contact->create($attributes);
        } catch (Exception $e) {
            return response()->json(['text' => UNABLE_ADD_MESSAGE, 'code' => 500]);
        }

        return response()->json(['emergency_contact' => $emergency_contact, 'text' => SUCCESS_ADD_MESSAGE, 'code' => 200]);

    }

    /**
     * Update the Profile - Emergency Contacts.
     *
     * @param EmergencyContactsRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function update(EmergencyContactsRequest $request)
    {
        $emergency_contact = $this->emergency_contact->whereId($request->get('emergency_contact_id'))->first();

        if (!$emergency_contact) {
            return redirect()->to($request->path())->with('danger', UNABLE_RETRIEVE_MESSAGE);
        }

        try {
            $attributes = array_filter($request->except('relationships', 'relationship'));
            $emergency_contact->update($attributes);

        } catch (Exception $e) {
            return response()->json(['text' => UNABLE_UPDATE_MESSAGE, 'code' => 500]);
        }

        return response()->json(['text' => SUCCESS_UPDATE_MESSAGE, 'code' => 200]);
    }

    /**
     * Delete the Profile - Emergency Contacts.
     *
     * @param EmergencyContactsRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function destroy(EmergencyContactsRequest $request)
    {
        $emergency_contact_id = $request->get('id');

        try {
            $this->emergency_contact->whereId($emergency_contact_id)->delete();
        } catch (Exception $e) {
            return response()->json(['text' => UNABLE_DELETE_MESSAGE, 'code' => 500]);
        }
        return response()->json(['text' => SUCCESS_DELETE_MESSAGE, 'code' => 200]);

    }
}
