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
use HRis\Eloquent\CustomFieldSection;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\PIM\CustomFieldSectionsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

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
     * @param Sentinel $auth
     * @param CustomFieldSection $custom_field_sections
     *
     * @author Bertrand Kintanar
     */
    public function __construct(Sentinel $auth, CustomFieldSection $custom_field_sections, CustomField $custom_fields)
    {
        parent::__construct($auth);

        $this->custom_fields = $custom_fields;
        $this->custom_field_sections = $custom_field_sections;
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

        $custom_fields = $this->custom_fields->wherePimCustomFieldSectionId($id)->get();

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
            'plural' => 'custom_field_sections',
            'dashed' => 'custom-field_sections',
        ];
        $table['items'] = $custom_field_sections;

        return $table;
    }

    /**
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
        $table['headers'] = ['Id', 'Name', 'Type', 'Required'];
        $table['model'] = [
            'singular' => 'custom_field',
            'plural' => 'custom_fields',
            'dashed' => 'custom-fields',
        ];
        $table['items'] = $custom_fields;

        return $table;
    }
}
