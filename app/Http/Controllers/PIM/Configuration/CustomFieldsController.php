<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Http\Controllers\PIM\Configuration;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Eloquent\CustomField;
use HRis\Eloquent\CustomFieldOption;
use HRis\Eloquent\CustomFieldSection;
use HRis\Eloquent\CustomFieldType;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\PIM\CustomFieldRequest;
use HRis\Http\Requests\PIM\CustomFieldSectionsRequest;
use Illuminate\Support\Facades\DB;

/**
 * Class CustomFieldsController.
 *
 * @Middleware("auth")
 */
class CustomFieldsController extends Controller
{
    /**
     * @var Employee
     */
    protected $employee;

    /**
     * @var CustomFieldSection
     */
    protected $custom_field_sections;

    /**
     * @var CustomField
     */
    protected $custom_fields;

    /**
     * @var CustomFieldType
     */
    protected $custom_field_type;

    /**
     * @param Sentinel           $auth
     * @param CustomFieldSection $custom_field_sections
     * @param CustomField        $custom_fields
     * @param CustomFieldType    $custom_field_type
     *
     * @author Bertrand Kintanar
     */
    public function __construct(
        Sentinel $auth,
        CustomFieldSection $custom_field_sections,
        CustomField $custom_fields,
        CustomFieldType $custom_field_type
    ) {
        parent::__construct($auth);

        $this->custom_fields = $custom_fields;
        $this->custom_field_sections = $custom_field_sections;
        $this->custom_field_type = $custom_field_type;
    }

    /**
     * Show the PIM - Custom Fields.
     *
     * @Get("pim/configuration/custom-field-sections")
     *
     * @return \Illuminate\View\View
     *
     * @author Bertrand Kintanar
     */
    public function index()
    {
        $custom_field_sections = $this->custom_field_sections->get();

        $this->data['table'] = $this->setupDataTable($custom_field_sections);
        $this->data['pageTitle'] = 'Custom Field Sections';

        return $this->template('pages.pim.configuration.custom-field-sections.view');
    }

    /**
     * Show a PIM - Custom Field Section.
     *
     * @Get("pim/configuration/custom-field-sections/{id}")
     *
     * @return \Illuminate\View\View
     *
     * @author Bertrand Kintanar
     */
    public function show($id)
    {
        $custom_field_section = $this->custom_field_sections->whereId($id)->first();

        if (!$custom_field_section) {
            return response()->make(view()->make('errors.404'), 404);
        }

        $custom_fields = $this->custom_fields->whereCustomFieldSectionId($id)->get();

        $this->data['custom_field_section'] = $custom_field_section;
        $this->data['table'] = $this->setupDataTableCustomField($custom_fields);
        $this->data['pageTitle'] = 'Custom Field Sections : '.$custom_field_section->name;

        return $this->template('pages.pim.configuration.custom-field-sections.show');
    }

    /**
     * Save the PIM - Custom Field Section.
     *
     * @Post("pim/configuration/custom-field-sections")
     *
     * @param CustomFieldSectionsRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar
     */
    public function store(CustomFieldSectionsRequest $request)
    {
        try {
            $this->custom_field_sections->create($request->all());
        } catch (Exception $e) {
            return redirect()->to($request->path())->with('danger', UNABLE_ADD_MESSAGE);
        }

        return redirect()->to($request->path())->with('success', SUCCESS_ADD_MESSAGE);
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
     * @author Bertrand Kintanar
     */
    public function storeCustomField(CustomFieldRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $custom_field_section = $this->custom_field_sections->whereId($id)->first();

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
     * @author Bertrand Kintanar
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
            'dashed'   => 'custom-field_sections',
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
     * @author Bertrand Kintanar
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
     * Update the PIM - Custom Field.
     *
     * @Patch("pim/configuration/custom-field-sections/{id}")
     *
     * @param CustomFieldRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar
     */
    public function update(CustomFieldRequest $request, $id)
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
}
