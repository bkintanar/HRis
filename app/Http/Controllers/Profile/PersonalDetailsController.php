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
use HRis\Eloquent\Employee;
use HRis\Eloquent\Navlink;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Profile\PersonalDetailsRequest;
use Illuminate\Support\Facades\Config;

/**
 * Class PersonalDetailsController.
 *
 * @Middleware("auth")
 */
class PersonalDetailsController extends Controller
{
    /**
     * @var Employee
     */
    protected $employee;

    /**
     * @var
     */
    protected $employee_id_prefix;

    /**
     * @param Sentinel         $auth
     * @param Employee         $employee
     * @param CustomFieldValue $custom_field_value
     *
     * @author Bertrand Kintanar
     */
    public function __construct(Sentinel $auth, Employee $employee, CustomFieldValue $custom_field_value)
    {
        parent::__construct($auth);

        $this->employee = $employee;
        $this->custom_field_value = $custom_field_value;
        $this->employee_id_prefix = Config::get('company.employee_id_prefix');

        $profile_details_id = Navlink::whereName('Personal Details')->pluck('id');
        $this->data['custom_field_sections'] = CustomFieldSection::with('customFields')->whereScreenId($profile_details_id)->get();
    }

    /**
     * Show the Profile - Personal Details.
     *
     * @Get("profile/personal-details")
     * @Get("pim/employee-list/{id}/personal-details")
     *
     * @param PersonalDetailsRequest $request
     * @param null                   $employee_id
     *
     * @return \Illuminate\View\View
     *
     * @author Bertrand Kintanar
     */
    public function index(PersonalDetailsRequest $request, $employee_id = null)
    {
        $employee = $this->employee->getEmployeeById($employee_id, $this->logged_user->id);

        if (!$employee) {
            return response()->make(view()->make('errors.404'), 404);
        }

        $custom_field_values = $this->custom_field_value->whereEmployeeId($employee->id)->lists('value', 'pim_custom_field_id');

        $this->data['employee'] = $employee;
        $this->data['custom_field_values'] = count($custom_field_values) ? $custom_field_values : null;
        $this->data['employee_id_prefix'] = $this->employee_id_prefix;

        $this->data['disabled'] = 'disabled';
        $this->data['pim'] = $request->is('*pim/*') ?: false;
        $this->data['pageTitle'] = $this->data['pim'] ? 'Employee Personal Details' : 'My Personal Details';

        return $this->template('pages.profile.personal-details.view');
    }

    /**
     * Show the Profile - Personal Details Form.
     *
     * @Get("profile/personal-details/edit")
     * @Get("pim/employee-list/{id}/personal-details/edit")
     *
     * @param PersonalDetailsRequest $request
     * @param null                   $employee_id
     *
     * @return \Illuminate\View\View
     *
     * @author Bertrand Kintanar
     */
    public function show(PersonalDetailsRequest $request, $employee_id = null)
    {
        $employee = $this->employee->getEmployeeById($employee_id, $this->logged_user->id);

        if (!$employee) {
            return response()->make(view()->make('errors.404'), 404);
        }

        $custom_field_values = $this->custom_field_value->whereEmployeeId($employee->id)->lists('value', 'pim_custom_field_id');

        $this->data['employee'] = $employee;
        $this->data['custom_field_values'] = count($custom_field_values) ? $custom_field_values : null;
        $this->data['employee_id_prefix'] = $this->employee_id_prefix;

        $this->data['disabled'] = '';
        $this->data['pim'] = $request->is('*pim/*') ?: false;
        $this->data['pageTitle'] = $this->data['pim'] ? 'Edit Employee Personal Details' : 'Edit My Personal Details';

        return $this->template('pages.profile.personal-details.edit');
    }

    /**
     * Update the Profile - Personal Details.
     *
     * @Patch("profile/personal-details")
     * @Patch("pim/employee-list/{id}/personal-details")
     *
     * @param PersonalDetailsRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar
     */
    public function update(PersonalDetailsRequest $request)
    {
        $id = $request->get('id');
        $employee_id = $request->get('employee_id');

        $employee = $this->employee->whereId($id)->first();

        if (!$employee) {
            return redirect()->to($request->path())->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        // If user is trying to update the employee_id to a used employee_id.
        $original_employee_id = $this->employee->whereEmployeeId($employee_id)->pluck('id');
        if ($id != $original_employee_id && !is_null($original_employee_id)) {
            $path = $request->path();

            // pim/employee-list/{id}/personal-details
            if ($request->is('*pim/*')) {
                $path = explode('/', $path);
                $path[2] = $employee->employee_id;
                $path = implode('/', $path);
            }

            return redirect()->to($path)->with('danger', EMPLOYEE_ID_IN_MESSAGE);
        }

        try {
            $employee->update($request->all());
        } catch (Exception $e) {
            return redirect()->to($request->path())->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        return redirect()->to($request->path())->with('success', SUCCESS_UPDATE_MESSAGE);
    }
}
