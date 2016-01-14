<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Controllers\PIM\Configuration;

use Exception;
use HRis\Api\Controllers\BaseController;
use HRis\Api\Eloquent\CustomField;
use HRis\Api\Eloquent\CustomFieldOption;
use HRis\Api\Eloquent\CustomFieldSection;
use HRis\Api\Eloquent\CustomFieldType;
use HRis\Api\Eloquent\Navlink;
use HRis\Api\Requests\PIM\CustomFieldRequest;
use HRis\Api\Requests\PIM\CustomFieldSectionsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class CustomFieldsController.
 */
class CustomFieldsController extends BaseController
{
    /**
     * @var CustomFieldSection
     */
    protected $custom_field_section;

    /**
     * @var CustomField
     */
    protected $custom_field;

    /**
     * @var CustomFieldType
     */
    protected $custom_field_type;

    /**
     * @param CustomFieldSection $custom_field_section
     * @param CustomField        $custom_field
     * @param CustomFieldType    $custom_field_type
     * @param CustomFieldOption  $custom_field_option
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function __construct(CustomFieldSection $custom_field_section, CustomField $custom_field, CustomFieldType $custom_field_type, CustomFieldOption $custom_field_option)
    {
        $this->custom_field = $custom_field;
        $this->custom_field_section = $custom_field_section;
        $this->custom_field_type = $custom_field_type;
        $this->custom_field_option = $custom_field_option;
    }

    /**
     * Delete the PIM - Custom Field Section.
     *
     * @param CustomFieldSectionsRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function destroy(CustomFieldSectionsRequest $request)
    {
        $custom_field_section_id = $request->get('id');

        try {
            $this->custom_field_section->whereId($custom_field_section_id)->delete();
        } catch (Exception $e) {
            return $this->response()->array(['message' => UNABLE_DELETE_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        return $this->response()->array(['message' => SUCCESS_DELETE_MESSAGE, 'status_code' => 200])->statusCode(200);
    }

    public function destroyCustomField(CustomFieldRequest $request)
    {
        $custom_field_id = $request->get('id');

        try {
            $this->custom_field->whereId($custom_field_id)->delete();
        } catch (Exception $e) {
            return $this->response()->array(['message' => UNABLE_DELETE_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        return $this->response()->array(['message' => SUCCESS_DELETE_MESSAGE, 'status_code' => 200])->statusCode(200);
    }

    /**
     * Show the PIM - Custom Fields.
     *
     * @return \Illuminate\View\View
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function index()
    {
        $custom_field_sections = $this->custom_field_section->with('screen')->get();

        $table = $this->setupDataTable($custom_field_sections);

        $response['data'] = $custom_field_sections;
        $response['table'] = $table;

        return response()->json($response);
    }

    /**
     * Show a PIM - Custom Field Section.
     *
     * @return \Illuminate\View\View
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function show(Request $request)
    {
        $custom_field_section_id = $request->get('custom_field_section_id');
        $custom_field_section = $this->custom_field_section->whereId($custom_field_section_id)->first();

        if (!$custom_field_section) {
            return response()->make(view()->make('errors.404'), 404);
        }

        $custom_fields = $this->custom_field->with('type', 'options')->whereCustomFieldSectionId($custom_field_section_id)->get();

        $response['data'] = $custom_fields;
        $response['table'] = $this->setupDataTableCustomField($custom_fields);

        return response()->json($response);
    }

    /**
     * Save the PIM - Custom Field Section.
     *
     * @param CustomFieldSectionsRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function store(CustomFieldSectionsRequest $request)
    {
        try {
            $response = $this->custom_field_section->create($request->all());
        } catch (Exception $e) {
            return $this->response()->array(['message' => UNABLE_ADD_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        $custom_field_section = $this->custom_field_section->with('screen')->whereId($response->id)->first();

        return $this->response()->array(['custom_field_section' => $custom_field_section, 'message' => SUCCESS_ADD_MESSAGE, 'status_code' => 201])->statusCode(201);
    }

    /**
     * Save the PIM - Custom Field.
     *
     * @param CustomFieldRequest $request
     * @param                    $id
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function storeCustomField(CustomFieldRequest $request)
    {
        $custom_field_section_id = $request->get('custom_field_section_id');
        try {
            DB::beginTransaction();

            $custom_field_section = $this->custom_field_section->whereId($custom_field_section_id)->first();

            $data = [
                'custom_field_type_id' => $request->get('type_id'),
                'name'                 => $request->get('name'),
                'required'             => $request->get('required'),
                'mask'                 => $request->has('mask') ? $request->get('mask') : null,
            ];

            // Create CustomField and attach it to the CustomFieldSection
            $custom_field = $custom_field_section->customFields()->create($data);

            $custom_field_type = $this->custom_field_type->whereId($data['custom_field_type_id'])->first();

            // Checks if the CustomFieldType has options
            if ($custom_field_type->has_options) {
                $options = explode(',', $request->get('custom_field_options'));

                foreach ($options as $option) {
                    $custom_field->options()->create(['name' => $option]);
                }
            }
        } catch (Exception $e) {
            DB::rollback();

            return $this->response()->array(['message' => UNABLE_ADD_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        DB::commit();

        $custom_field = $this->custom_field->with('type', 'options')->whereId($custom_field->id)->first();

        return $this->response()->array(['custom_field' => $custom_field, 'message' => SUCCESS_ADD_MESSAGE, 'status_code' => 201])->statusCode(201);
    }

    /**
     * Setup table for custom field section.
     *
     * @param $custom_field_sections
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function setupDataTable($custom_field_sections)
    {
        $table = [];

        $table['title'] = 'Custom Field Sections';
        $table['permission'] = 'pim.configuration.custom-field-sections';
        $table['headers'] = ['Id', 'Name', 'Screen'];
        $table['model'] = [
            'singular' => 'custom_field_section',
            'plural'   => 'custom_field_sections',
            'dashed'   => 'custom-field-sections',
        ];
        $table['items'] = $custom_field_sections;

        return $table;
    }

    /**
     * Setup table for custom field.
     *
     * @param $custom_fields
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function setupDataTableCustomField($custom_fields)
    {
        $table = [];

        $table['title'] = 'Custom Fields';
        $table['permission'] = 'pim.configuration.custom-fields';
        $table['headers'] = ['Id', 'Name', 'Type', 'Mask', 'Has Options', 'Required'];
        $table['model'] = [
            'singular' => 'custom_field',
            'plural'   => 'custom_fields',
            'dashed'   => 'custom-fields',
        ];
        $table['items'] = $custom_fields;

        return $table;
    }

    /**
     * Update the PIM - Custom Field Section.
     *
     * @param CustomFieldSectionsRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function update(CustomFieldSectionsRequest $request)
    {
        try {
            DB::beginTransaction();

            $custom_field_section = CustomFieldSection::whereId($request->get('custom_field_section_id'))->first();

            $custom_field_section->update($request->only(['name', 'screen_id']));
        } catch (Exception $e) {
            DB::rollback();

            return $this->response()->array(['message' => UNABLE_UPDATE_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        DB::commit();

        return $this->response()->array(['message' => SUCCESS_UPDATE_MESSAGE, 'status_code' => 200])->statusCode(200);
    }

    /**
     * Update the PIM - Custom Field.
     *
     * @param CustomFieldRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function updateCustomField(CustomFieldRequest $request)
    {
        try {
            DB::beginTransaction();

            $custom_field = $this->custom_field->whereId($request->get('custom_field_id'))->first();

            $data = [
                'custom_field_type_id' => $request->get('type_id'),
                'name'                 => $request->get('name'),
                'required'             => $request->get('required'),
                'mask'                 => $request->has('mask') ? $request->get('mask') : null,
            ];

            $custom_field->update($data);

            $custom_field_type = $this->custom_field_type->whereId($data['custom_field_type_id'])->first();

            // Checks if the CustomFieldType has options.
            if ($custom_field_type->has_options) {
                $old_options = $this->custom_field_option->whereCustomFieldId($custom_field->id)->get();
                $options = explode(',', $request->get('custom_field_options'));

                // Delete database entry that aren't in the new option list.
                foreach ($old_options as $option) {
                    if (!in_array($option->name, $options)) {
                        $option->delete();
                    }
                }

                foreach ($options as $option) {
                    $custom_field_option = $this->custom_field_option->whereCustomFieldId($custom_field->id)->whereName($option)->count();

                    // Only add to database those options that aren't there yet.
                    if (!$custom_field_option) {
                        $custom_field->options()->create(['name' => $option]);
                    }
                }
            }
        } catch (Exception $e) {
            DB::rollback();

            return $this->response()->array(['message' => UNABLE_UPDATE_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        DB::commit();

        return $this->response()->array(['message' => SUCCESS_UPDATE_MESSAGE, 'status_code' => 200])->statusCode(200);
    }

    public function getCustomFieldSectionsByScreenId(Request $request)
    {
        $screen_id = Navlink::whereName($request->get('screen_name'))->pluck('id');

        $custom_field_sections = $this->custom_field_section->with('customFields.options')->whereScreenId($screen_id)->get();

        $custom_field_sections->each(function ($custom_field_section) {
            $custom_fields = $custom_field_section->customFields;

            $custom_field_section->fields = array_chunk($custom_fields->toArray(), 2);
        });

        return $this->response()->array(['custom_field_sections' => $custom_field_sections, 'status_code' => 200])->statusCode(200);
    }
}
