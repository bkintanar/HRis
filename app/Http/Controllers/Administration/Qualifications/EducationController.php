<?php

namespace HRis\Http\Controllers\Administration\Qualifications;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Eloquent\EducationLevel;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Administration\EducationRequest;
use Illuminate\Support\Facades\Redirect;

/**
 * Class EducationController
 * @package HRis\Http\Controllers\Administration\Qualifications
 *
 * @Middleware("auth")
 */
class EducationController extends Controller
{

    /**
     * @var EducationLevel
     */
    protected $education;

    /**
     * @param Sentinel $auth
     * @param EducationLevel $education
     */
    public function __construct(Sentinel $auth, EducationLevel $education)
    {
        parent::__construct($auth);

        $this->education = $education;
    }

    /**
     * Show the Administration - Job Education.
     *
     * @Get("admin/qualifications/educations")
     *
     * @param EducationRequest $request
     *
     * @return \Illuminate\View\View
     */
    public function index(EducationRequest $request)
    {
        $educations = EducationLevel::where('id', '>', 0)->get();

        $this->data['table'] = $this->setupDataTable($educations);

        $this->data['pageTitle'] = 'Educations';

        return $this->template('pages.administration.qualifications.educations.view');
    }

    /**
     * @return array
     */
    public function setupDataTable($educations)
    {
        $table = [];

        $table['title'] = 'Education';
        $table['permission'] = 'admin.qualifications.educations';
        $table['headers'] = ['Id', 'Name'];
        $table['model'] = ['singular' => 'education', 'plural' => 'educations', 'dashed' => 'educations'];
        $table['items'] = $educations;

        return $table;
    }

    /**
     * Save the Administration - Job Education.
     *
     * @Post("admin/qualifications/educations")
     *
     * @param EducationRequest $request
     */
    public function store(EducationRequest $request)
    {
        try {
            $this->education->create($request->all());

        } catch (Exception $e) {
            return Redirect::to($request->path())->with('danger', UNABLE_ADD_MESSAGE);
        }

        return Redirect::to($request->path())->with('success', SUCCESS_ADD_MESSAGE);
    }

    /**
     * Update the Administration - Job Education.
     *
     * @Patch("admin/qualifications/educations")
     *
     * @param EducationRequest $request
     */
    public function update(EducationRequest $request)
    {
        $education = $this->education->whereId($request->get('education_id'))->first();

        if ( ! $education) {
            return Redirect::to($request->path())->with('danger', UNABLE_RETRIEVE_MESSAGE);
        }

        try {
            $education->update($request->all());

        } catch (Exception $e) {
            return Redirect::to($request->path())->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        return Redirect::to($request->path())->with('success', SUCCESS_UPDATE_MESSAGE);
    }
}
