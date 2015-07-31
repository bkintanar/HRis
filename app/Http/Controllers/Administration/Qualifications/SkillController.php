<?php

namespace HRis\Http\Controllers\Administration\Qualifications;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Eloquent\Skill;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Administration\SkillRequest;

/**
 * Class SkillController
 * @package HRis\Http\Controllers\Administration\Qualifications
 *
 * @Middleware("auth")
 */
class SkillController extends Controller
{
    /**
     * @var Skill
     */
    protected $skill;

    /**
     * @param Sentinel $auth
     * @param Skill $skill
     */
    public function __construct(Sentinel $auth, Skill $skill)
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
        $skills = Skill::where('id', '>', 0)->get();

        $this->data['table'] = $this->setupDataTable($skills);
        $this->data['pageTitle'] = 'Skills';

        return $this->template('pages.administration.qualifications.skills.view');
    }

    /**
     * @return array
     */
    public function setupDataTable($skills)
    {
        $table = [];

        $table['title'] = 'Skills';
        $table['permission'] = 'admin.qualifications.skills';
        $table['headers'] = ['Id', 'Name'];
        $table['model'] = ['singular' => 'skill', 'plural' => 'skills', 'dashed' => 'skills'];
        $table['items'] = $skills;

        return $table;
    }

    /**
     * Save the Administration - Job Skill.
     *
     * @Post("admin/qualifications/skills")
     *
     * @param SkillRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SkillRequest $request)
    {
        try {
            $this->skill->create($request->all());
        } catch (Exception $e) {
            return redirect()->to($request->path())->with('danger', UNABLE_ADD_MESSAGE);
        }

        return redirect()->to($request->path())->with('success', SUCCESS_ADD_MESSAGE);
    }

    /**
     * Update the Administration - Job Skill.
     *
     * @Patch("admin/qualifications/skills")
     *
     * @param SkillRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SkillRequest $request)
    {
        $skill = $this->skill->whereId($request->get('skill_id'))->first();

        if (! $skill) {
            return redirect()->to($request->path())->with('danger', UNABLE_RETRIEVE_MESSAGE);
        }

        try {
            $skill->update($request->all());
        } catch (Exception $e) {
            return redirect()->to($request->path())->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        return redirect()->to($request->path())->with('success', SUCCESS_UPDATE_MESSAGE);
    }
}
