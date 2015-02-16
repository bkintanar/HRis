<?php namespace HRis\Http\Controllers\Profile;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Exception;
use HRis\Education;
use HRis\Employee;
use HRis\EmployeeSkill;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Profile\QualificationsEducationRequest;
use HRis\Http\Requests\Profile\QualificationsRequest;
use HRis\Http\Requests\Profile\QualificationsSkillRequest;
use HRis\Http\Requests\Profile\QualificationsWorkExperienceRequest;
use HRis\WorkExperience;
use Illuminate\Support\Facades\Redirect;

/**
 * @Middleware("auth")
 */
class QualificationsController extends Controller {

    /**
     * @var Employee
     */
    protected $employee;

    /**
     * @param Sentry $auth
     * @param Employee $employee
     */
    public function __construct(Sentry $auth, Employee $employee)
    {
        parent::__construct($auth);

        $this->employee = $employee;
    }

    /**
     * Show the Profile - Qualifications.
     *
     * @Get("profile/qualifications")
     * @Get("pim/employee-list/{id}/qualifications")
     *
     * @param QualificationsRequest $request
     * @param null $employee_id
     *
     * @return \Illuminate\View\View
     */
    public function index(QualificationsRequest $request, $employee_id = null)
    {
        $employee = $this->employee->getEmployeeById($employee_id, $this->loggedUser->id);

        if ( ! $employee)
        {
            return Response::make(View::make('errors.404'), 404);
        }

        $this->data['employee'] = $employee;

        $this->data['workExperiences'] = $employee->workExperiences;
        $this->data['educations'] = $employee->educations;
        $this->data['skills'] = $employee->skills;

        $this->data['pim'] = $request->is('*pim/*') ? : false;
        $this->data['pageTitle'] = $this->data['pim'] ? 'Employee Qualifications' : 'My Qualifications';

        return $this->template('pages.profile.qualifications.view');
    }

    /**
     * Save the Profile - Qualifications - Work Experiences.
     *
     * @Post("profile/qualifications/work-experiences")
     * @Post("pim/employee-list/{id}/qualifications/work-experiences")
     *
     * @param QualificationsWorkExperienceRequest $request
     * @param WorkExperience $workExperience
     */
    public function storeWorkExperience(QualificationsWorkExperienceRequest $request, WorkExperience $workExperience)
    {
        try
        {
            $workExperience->create($request->all());

        } catch (Exception $e)
        {
//            dd($e->getMessage());
            return Redirect::to(str_replace('/work-experiences', '', $request->path()))->with('danger', UNABLE_ADD_MESSAGE);
        }

        return Redirect::to(str_replace('/work-experiences', '', $request->path()))->with('success', SUCCESS_ADD_MESSAGE);
    }

    /**
     * Update the Profile - Qualifications - Work Experiences.
     *
     * @Patch("profile/qualifications/work-experiences")
     * @Patch("pim/employee-list/{id}/qualifications/work-experiences")
     *
     * @param QualificationsWorkExperienceRequest $request
     * @param WorkExperience $workExperience
     */
    public function updateWorkExperience(QualificationsWorkExperienceRequest $request, WorkExperience $workExperience)
    {
        $workExperience = $workExperience->whereId($request->get('work_experience_id'))->first();

        if ( ! $workExperience)
        {
            return Redirect::to(str_replace('/work-experiences', '', $request->path()))->with('danger', UNABLE_RETRIEVE_MESSAGE);
        }

        try
        {
            $workExperience->update($request->all());

        } catch (Exception $e)
        {
//            dd($e->getMessage());
            return Redirect::to(str_replace('/work-experiences', '', $request->path()))->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        return Redirect::to(str_replace('/work-experiences', '', $request->path()))->with('success', SUCCESS_UPDATE_MESSAGE);

    }

    /**
     * Save the Profile - Qualifications - Education.
     *
     * @Post("profile/qualifications/educations")
     * @Post("pim/employee-list/{id}/qualifications/educations")
     *
     * @param QualificationsEducationRequest $request
     * @param Education $education
     */
    public function storeEducation(QualificationsEducationRequest $request, Education $education)
    {
        try
        {
            $education->create($request->all());

        } catch (Exception $e)
        {
            return Redirect::to(str_replace('/educations', '', $request->path()))->with('danger', UNABLE_ADD_MESSAGE);
        }

        return Redirect::to(str_replace('/educations', '', $request->path()))->with('success', SUCCESS_ADD_MESSAGE);
    }

    /**
     * Update the Profile - Qualifications - Education.
     *
     * @Patch("profile/qualifications/educations")
     * @Patch("pim/employee-list/{id}/qualifications/educations")
     *
     * @param QualificationsEducationRequest $request
     * @param Education $education
     */
    public function updateEducation(QualificationsEducationRequest $request, Education $education)
    {
        $education = $education->whereId($request->get('education_id'))->first();

        if ( ! $education)
        {
            return Redirect::to(str_replace('/educations', '', $request->path()))->with('danger', UNABLE_RETRIEVE_MESSAGE);
        }

        try
        {
            $education->update($request->all());

        } catch (Exception $e)
        {
            return Redirect::to(str_replace('/educations', '', $request->path()))->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        return Redirect::to(str_replace('/educations', '', $request->path()))->with('success', SUCCESS_UPDATE_MESSAGE);
    }

    /**
     * Save the Profile - Qualifications - Skills.
     *
     * @Post("profile/qualifications/skills")
     * @Post("pim/employee-list/{id}/qualifications/skills")
     *
     * @param QualificationsSkillRequest $request
     */
    public function storeSkill(QualificationsSkillRequest $request)
    {
        try
        {
            $employee = $this->employee->whereId($request->get('id'))->first();

            $skill_id = $request->get('skill_id');
            $years_of_experience = $request->get('years_of_experience') or null;
            $comment = $request->get('skill_comment') or null;

            $employee->skills()->attach($skill_id, [
                'years_of_experience' => $years_of_experience,
                'comment'             => $comment
            ]);

        } catch (Exception $e)
        {
            return Redirect::to(str_replace('/skills', '', $request->path()))->with('danger', UNABLE_ADD_MESSAGE);
        }

        return Redirect::to(str_replace('/skills', '', $request->path()))->with('success', SUCCESS_ADD_MESSAGE);
    }

    /**
     * Update the Profile - Qualifications - Skills.
     *
     * @Patch("profile/qualifications/skills")
     * @Patch("pim/employee-list/{id}/qualifications/skills")
     *
     * @param QualificationsSkillRequest $request
     * @param EmployeeSkill $employeeSkill
     */
    public function updateSkill(QualificationsSkillRequest $request, EmployeeSkill $employeeSkill)
    {
        $employeeSkill = $employeeSkill->whereId($request->get('employee_skill_id'))->first();

        if ( ! $employeeSkill)
        {
            return Redirect::to(str_replace('/skills', '', $request->path()))->with('danger', UNABLE_RETRIEVE_MESSAGE);
        }

        try
        {
            $employeeSkill->skill_id = $request->get('skill_id');
            $employeeSkill->years_of_experience = $request->get('years_of_experience') ? : null;
            $employeeSkill->comment = $request->get('skill_comment') ? : null;

            $employeeSkill->save();

        } catch (Exception $e)
        {
            return Redirect::to(str_replace('/skills', '', $request->path()))->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        return Redirect::to(str_replace('/skills', '', $request->path()))->with('success', SUCCESS_UPDATE_MESSAGE);
    }
}
