<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Controllers\PIM\Configuration;

use Dingo\Api\Facade\API;
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
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function __construct(CustomFieldSection $custom_field_section, CustomField $custom_field, CustomFieldType $custom_field_type)
    {
        $this->custom_field = $custom_field;
        $this->custom_field_section = $custom_field_section;
        $this->custom_field_type = $custom_field_type;
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
            return API::response()->array(['status' => UNABLE_DELETE_MESSAGE])->statusCode(500);
        }

        return API::response()->array(['status' => SUCCESS_DELETE_MESSAGE])->statusCode(200);
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
     * @Get("pim/configuration/custom-field-sections/{id}")
     *
     * @return \Illuminate\View\View
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function show($id)
    {
        $custom_field_section = $this->custom_field_section->whereId($id)->first();

        if (!$custom_field_section) {
            return response()->make(view()->make('errors.404'), 404);
        }

        $custom_fields = $this->custom_field->whereCustomFieldSectionId($id)->get();

        $this->data['custom_field_section'] = $custom_field_section;
        $this->data['table'] = $this->setupDataTableCustomField($custom_fields);
        $this->data['pageTitle'] = 'Custom Field Sections : '.$custom_field_section->name;

        return $this->template('pages.pim.configuration.custom-field-sections.show');
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
            return API::response()->array(['status' => UNABLE_ADD_MESSAGE])->statusCode(500);
        }

        $custom_field_section = $this->custom_field_section->with('screen')->whereId($response->id)->first();

        return API::response()->array(['custom_field_section' => $custom_field_section, 'status' => SUCCESS_ADD_MESSAGE])->statusCode(200);
    }

    /**
     * Save the PIM - Custom Field.
     *
     * @Post("pim/configuration/custom-field-sections/{id}")
     *
     * @param CustomFieldRequest $request
     * @param                    $id
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function storeCustomField(CustomFieldRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $custom_field_section = $this->custom_field_section->whereId($id)->first();

            $data = [
                'custom_field_type_id' => $request->get('custom_field_type_id'),
                'name'                 => $request->get('field_name'),
                'required'             => $request->has('required') ? $request->get('required') : 0,
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

            return redirect()->to($request->path())->with('danger', UNABLE_ADD_MESSAGE);
        }

        DB::commit();

        return redirect()->to($request->path())->with('success', SUCCESS_ADD_MESSAGE);
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
        $table['headers'] = ['Id', 'Name', 'Type', 'Has Options', 'Required'];
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

            return API::response()->array(['status' => UNABLE_UPDATE_MESSAGE])->statusCode(500);
        }

        DB::commit();

        return API::response()->array(['status' => SUCCESS_UPDATE_MESSAGE])->statusCode(200);
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

            $custom_field = CustomField::whereId($request->get('custom_field_id'))->first();

            $data = [
                'custom_field_type_id' => $request->get('custom_field_type_id'),
                'name'                 => $request->get('field_name'),
                'required'             => $request->has('required') ? $request->get('required') : 0,
            ];

            $custom_field->update($data);

            $custom_field_type = $this->custom_field_type->whereId($data['custom_field_type_id'])->first();

            // Checks if the CustomFieldType has options.
            if ($custom_field_type->has_options) {
                $old_options = CustomFieldOption::whereCustomFieldId($custom_field->id)->get();
                $options = explode(',', $request->get('custom_field_options'));

                // Delete database entry that aren't in the new option list.
                foreach ($old_options as $option) {
                    if (!in_array($option->name, $options)) {
                        $option->delete();
                    }
                }

                foreach ($options as $option) {
                    $custom_field_option = CustomFieldOption::whereCustomFieldId($custom_field->id)->whereName($option)->count();

                    // Only add to database those options that aren't there yet.
                    if (!$custom_field_option) {
                        $custom_field->options()->create(['name' => $option]);
                    }
                }
            }
        } catch (Exception $e) {
            DB::rollback();

            return redirect()->to($request->path())->with('danger', UNABLE_ADD_MESSAGE);
        }

        DB::commit();

        return redirect()->to($request->path())->with('success', SUCCESS_ADD_MESSAGE);
    }

    public function getCustomFieldSectionsByScreenId(Request $request)
    {
        $screen_id = Navlink::whereName($request->get('screen_name'))->pluck('id');

        $custom_field_sections = $this->custom_field_section->with('customFields.options')->whereScreenId($screen_id)->get();

        $custom_field_sections->each(function ($custom_field_section) {
            $custom_fields = $custom_field_section->customFields;

            $custom_field_section->fields = array_chunk($custom_fields->toArray(), 2);
        });

        return API::response()->array(['custom_field_sections' => $custom_field_sections])->statusCode(200);
    }
}
