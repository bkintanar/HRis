<?php

/*
 * This file is part of the HRis Software package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @version    alpha
 *
 * @author     Bertrand Kintanar <bertrand.kintanar@gmail.com>
 * @license    BSD License (3-clause)
 * @copyright  (c) 2014-2016, b8 Studios, Ltd
 *
 * @link       http://github.com/HB-Co/HRis
 */

namespace HRis\Api\Controllers\Profile;

use Exception;
use Illuminate\Http\Request;
use Irradiate\Api\Controllers\BaseController;
use Irradiate\Eloquent\CustomFieldValue;

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

        try {
            foreach ($custom_field_ids as $custom_field_id) {
                $data = [
                    'custom_field_id' => $custom_field_id,
                    'employee_id'     => $employee_id,
                ];

                $values = array_merge($data, ['value' => $custom_field_values[$custom_field_id]]);

                $this->custom_field_value->updateOrCreate($data, $values);
            }
        } catch (Exception $e) {
            return $this->responseAPI(422, UNABLE_UPDATE_MESSAGE);
        }

        return $this->responseAPI(200, SUCCESS_UPDATE_MESSAGE);
    }
}
