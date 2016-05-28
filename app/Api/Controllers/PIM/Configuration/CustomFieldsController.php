<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
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
     * @var CustomFieldOption
     */
    protected $custom_field_option;

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
     * @param CustomFieldSection         $custom_field_section
     * @param CustomFieldSectionsRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function destroy(CustomFieldSection $custom_field_section, CustomFieldSectionsRequest $request)
    {
        return $this->destroyModel($custom_field_section, $this->custom_field_section);
    }

    /**
     * Delete the PIM - Custom Field.
     *
     * @param CustomField        $custom_field
     * @param CustomFieldRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function destroyCustomField(CustomField $custom_field, CustomFieldRequest $request)
    {
        return $this->destroyModel($custom_field, $this->custom_field);
    }

    /**
     * Show the PIM - Custom Fields.
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function index()
    {
        $custom_field_sections = $this->custom_field_section->with('screen')->paginate(ROWS_PER_PAGE);

        $data = ['data' => $custom_field_sections, 'table' => $this->setupDataTable($custom_field_sections)];

        return $this->responseAPI(200, SUCCESS_RETRIEVE_MESSAGE, $data);
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
     * Show a PIM - Custom Field Section.
     *
     * @param Request $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function show(Request $request)
    {
        $custom_field_section_id = $request->get('custom_field_section_id');
        $custom_field_section = $this->custom_field_section->whereId($custom_field_section_id)->first();

        if (!$custom_field_section) {
            return $this->responseAPI(404, UNABLE_RETRIEVE_MESSAGE);
        }

        $custom_fields = $this->custom_field->with('type', 'options')->whereCustomFieldSectionId($custom_field_section_id)->paginate(ROWS_PER_PAGE);

        $data = ['data' => $custom_fields, 'table' => $this->setupDataTableCustomField($custom_fields)];

        return $this->responseAPI(200, SUCCESS_RETRIEVE_MESSAGE, $data);
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
     * Save the PIM - Custom Field Section.
     *
     * @param CustomFieldSectionsRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function store(CustomFieldSectionsRequest $request)
    {
        return $this->storeModel($request, $this->custom_field_section, 'custom_field_section');
    }

    /**
     * Save the PIM - Custom Field.
     *
     * @param CustomFieldRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function storeCustomField(CustomFieldRequest $request)
    {
        $custom_field_section_id = $request->get('custom_field_section_id');
        try {
            DB::beginTransaction();

            $custom_field_section = $this->custom_field_section->findOrFail($custom_field_section_id);

            $data = $this->getRequestData($request);

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

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return $this->responseAPI(422, UNABLE_ADD_MESSAGE);
        }

        $custom_field = $this->custom_field->with('type', 'options')->whereId($custom_field->id)->first();

        return $this->responseAPI(201, SUCCESS_ADD_MESSAGE, compact('custom_field'));
    }

    /**
     * Update the PIM - Custom Field Section.
     *
     * @param CustomFieldSectionsRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function update(CustomFieldSectionsRequest $request)
    {
        try {
            $custom_field_section = $this->custom_field_section->whereId($request->get('custom_field_section_id'))->first();

            if (!$custom_field_section) {
                return $this->responseAPI(404, UNABLE_RETRIEVE_MESSAGE);
            }

            $custom_field_section->update($request->only(['name', 'screen_id']));
        } catch (Exception $e) {
            return $this->responseAPI(422, UNABLE_UPDATE_MESSAGE);
        }

        return $this->responseAPI(200, SUCCESS_UPDATE_MESSAGE);
    }

    /**
     * Update the PIM - Custom Field.
     *
     * @param CustomFieldRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function updateCustomField(CustomFieldRequest $request)
    {
        try {
            $custom_field = $this->custom_field->whereId($request->get('custom_field_id'))->first();

            if (!$custom_field) {
                return $this->responseAPI(404, UNABLE_RETRIEVE_MESSAGE);
            }

            $data = $this->getRequestData($request);

            $custom_field->update($data);

            $custom_field_type = $this->custom_field_type->whereId($data['custom_field_type_id'])->first();

            // Checks if the CustomFieldType has options.
            if ($custom_field_type->has_options) {
                $old_options = $this->custom_field_option->whereCustomFieldId($custom_field->id)->get();
                $options = explode(',', $request->get('custom_field_options'));

                // Delete database entry that aren't in the new option list.
                $this->deleteOldOptions($options, $old_options);

                // Assign / Create database entry basing on the new option list.
                $this->createNewOptions($options, $custom_field);
            }
        } catch (Exception $e) {
            return $this->responseAPI(422, UNABLE_UPDATE_MESSAGE);
        }

        return $this->responseAPI(200, SUCCESS_UPDATE_MESSAGE);
    }

    /**
     * Set the data before processing it.
     *
     * @param CustomFieldRequest $request
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    private function getRequestData(CustomFieldRequest $request)
    {
        return [
            'custom_field_type_id' => $request->get('type_id'),
            'name'                 => $request->get('name'),
            'required'             => $request->get('required'),
            'mask'                 => $request->has('mask') ? $request->get('mask') : null,
        ];
    }

    /**
     * Delete database entry that aren't in the new option list.
     *
     * @param $options
     * @param $old_options
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    private function deleteOldOptions($options, $old_options)
    {
        foreach ($old_options as $option) {
            if (!in_array($option->name, $options)) {
                $option->delete();
            }
        }
    }

    /**
     * Create database entry basing on the new option list.
     *
     * @param $options
     * @param $custom_field
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    private function createNewOptions($options, $custom_field)
    {
        foreach ($options as $option) {
            $custom_field_option = $this->custom_field_option->whereCustomFieldId($custom_field->id)->whereName($option)->count();

            // Only add to database those options that aren't there yet.
            if (!$custom_field_option) {
                $custom_field->options()->create(['name' => $option]);
            }
        }
    }

    /**
     * Get Custom Field Sections by Screen Id.
     *
     * @param Request $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function getCustomFieldSectionsByScreenId(Request $request)
    {
        $screen_id = Navlink::whereName($request->get('screen_name'))->value('id');

        $custom_field_sections = $this->custom_field_section->with('customFields.options')->whereScreenId($screen_id)->get();

        $custom_field_sections->each(function ($custom_field_section) {
            $custom_fields = $custom_field_section->customFields;

            $custom_field_section->fields = array_chunk($custom_fields->toArray(), 2);
        });

        return $this->responseAPI(200, SUCCESS_RETRIEVE_MESSAGE, compact('custom_field_sections'));
    }
}
