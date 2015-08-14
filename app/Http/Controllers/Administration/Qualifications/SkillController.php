<?php namespace HRis\Http\Controllers\Administration\Qualifications;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use HRis\Eloquent\Skill;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Administration\SkillRequest;
use Illuminate\Support\Facades\Redirect;

/**
 * @Middleware("auth")
 */
class SkillController extends Controller {

    /**
     * @var Skill
     */
    protected $skill;

    /**
     * @param Sentry $auth
     * @param Skill $skill
     */
    public function __construct(Sentry $auth, Skill $skill)
    {
        parent::__construct($auth);

        $this->skill = $skill;
    }

    /**
     * Show the Administration - Job Skill.
     *
     * @Get("admin/qualifications/skills")
     *
     * @param SkillRequest $request
     * @return \Illuminate\View\View
     */
    public function index(SkillRequest $request)
    {
        $this->data['skills'] = Skill::where('id', '>', 0)->get();

        $this->data['pageTitle'] = 'Skills';

        return $this->template('pages.administration.qualifications.skills.view');
    }

    /**
     * Save the Administration - Job Skill.
     *
     * @Post("admin/qualifications/skills")
     *
     * @param SkillRequest $request
     */
    public function store(SkillRequest $request)
    {
        try
        {
            $this->skill->create($request->all());

        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to add record to the database.');
        }

        return Redirect::to($request->path())->with('success', 'Record successfully added.');
    }

    /**
     * Update the Administration - Job Skill.
     *
     * @Patch("admin/qualifications/skills")
     *
     * @param SkillRequest $request
     */
    public function update(SkillRequest $request)
    {
        $skill = $this->skill->whereId($request->get('skill_id'))->first();

        if ( ! $skill)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to retrieve record from database.');
        }

        try
        {
            $skill->update($request->all());

        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to update record.');
        }

        return Redirect::to($request->path())->with('success', 'Record successfully updated.');
    }
}
