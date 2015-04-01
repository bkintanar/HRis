<?php namespace HRis\Http\Controllers\Administration\Qualifications;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use HRis\Eloquent\EducationLevel;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Administration\EducationRequest;
use Illuminate\Support\Facades\Redirect;

/**
 * @Middleware("auth")
 */
class EducationController extends Controller {

    /**
     * @var EducationLevel
     */
    protected $education;

    /**
     * @param Sentry $auth
     * @param EducationLevel $education
     */
    public function __construct(Sentry $auth, EducationLevel $education)
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
        $this->data['educations'] = EducationLevel::where('id', '>', 0)->get();

        $this->data['pageTitle'] = 'Educations';

        return $this->template('pages.administration.qualifications.educations.view');
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
        try
        {
            $this->education->create($request->all());

        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to add record to the database.');
        }

        return Redirect::to($request->path())->with('success', 'Record successfully added.');
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

        if ( ! $education)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to retrieve record from database.');
        }

        try
        {
            $education->update($request->all());

        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to update record.');
        }

        return Redirect::to($request->path())->with('success', 'Record successfully updated.');
    }
}
