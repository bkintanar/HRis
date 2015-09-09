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
use HRis\Eloquent\CustomFieldValue;
use HRis\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class MainController.
 *
 * @Middleware("auth")
 */
class MainController extends Controller
{
    /**
     * @var CustomFieldValue
     */
    protected $custom_field_value;

    /**
     * @param Sentinel         $auth
     * @param CustomFieldValue $custom_field_value
     *
     * @author Bertrand Kintanar
     */
    public function __construct(Sentinel $auth, CustomFieldValue $custom_field_value)
    {
        parent::__construct($auth);
        $this->custom_field_value = $custom_field_value;
    }

    /**
     * @Get("profile")
     *
     * @author Bertrand Kintanar
     */
    public function index()
    {
        return redirect()->to('profile/personal-details');
    }

    /**
     * Update the Profile - Personal Details Custom Fields.
     *
     * @Patch("profile/{screen}/custom-fields")
     * @Patch("pim/employee-list/{id}/{screen}/custom-fields")
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar
     */
    public function updateCustomFields(Request $request)
    {
        $custom_fields = $request->except('_method', '_token', 'id');

        $id = $request->get('id');

        DB::beginTransaction();

        try {
            foreach ($custom_fields as $key => $custom_field) {
                $custom_field_id = (int) str_replace('custom_field_', '', $key);

                $data = [
                    'custom_field_id' => $custom_field_id,
                    'employee_id'     => $id,
                ];

                $custom_field_value = $this->custom_field_value->firstOrCreate($data);
                $custom_field_value->value = $custom_field;
                $custom_field_value->save();
            }
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->to(str_replace('/custom-fields', '', $request->path()))->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        DB::commit();

        return redirect()->to(str_replace('/custom-fields', '', $request->path()))->with('success', SUCCESS_UPDATE_MESSAGE);
    }
}
