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

        if ( ! $education)
        {
            return Redirect::to($request->path())->with('danger', UNABLE_RETRIEVE_MESSAGE);
        }

        try
        {
            $education->update($request->all());

        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        return Redirect::to($request->path())->with('success', SUCCESS_UPDATE_MESSAGE);
    }
}
