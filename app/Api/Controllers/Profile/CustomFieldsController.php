<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Controllers\Profile;

use Exception;
use HRis\Api\Controllers\BaseController;
use HRis\Api\Eloquent\CustomFieldValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomFieldsController extends BaseController
{
    /**
     * @var CustomFieldValue
     */
    protected $custom_field_value;

    /**
     * @param CustomFieldValue $custom_field_value
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function __construct(CustomFieldValue $custom_field_value)
    {
        $this->custom_field_value = $custom_field_value;
    }

    /**
     * Update the Profile - CustomFields.
     *
     * @param Request $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function update(Request $request)
    {
        $custom_field_values = array_filter($request->get('custom_field_values'));

        foreach ($custom_field_values as $key => $custom_field_value) {
            if (is_array($custom_field_value)) {
                $custom_field_values[$key] = $custom_field_value['id'];
            }
        }

        $custom_field_ids = array_keys($custom_field_values);
        $employee_id = $request->get('employee_id');

        DB::beginTransaction();

        try {
            foreach ($custom_field_ids as $custom_field_id) {
                $data = [
                    'custom_field_id' => $custom_field_id,
                    'employee_id'     => $employee_id,
                ];

                $custom_field_value = $this->custom_field_value->firstOrCreate($data);
                $custom_field_value->value = $custom_field_values[$custom_field_id];
                $custom_field_value->save();
            }
        } catch (Exception $e) {
            DB::rollBack();

            return $this->responseAPI(422, UNABLE_UPDATE_MESSAGE);
        }

        DB::commit();

        return $this->responseAPI(200, SUCCESS_UPDATE_MESSAGE);
    }
}
