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
     * @return \Illuminate\View\View
     */
    public function qualifications(QualificationsRequest $request, $employee_id = null)
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

        $this->data['pim'] = $request->is('*pim/*') ? true : false;
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
     * @return
     */
    public function saveWorkExperience(QualificationsWorkExperienceRequest $request, WorkExperience $workExperience)
    {
        try
        {
            $workExperience->employee_id = $request->get('id');
            $workExperience->company = $request->get('company');
            $workExperience->job_title = $request->get('job_title');
            $workExperience->from_date = $request->get('from_date') ? $request->get('from_date') : null;
            $workExperience->to_date = $request->get('to_date') ? $request->get('to_date') : null;
            $workExperience->comment = $request->get('comment');

            $workExperience->save();
        } catch (Exception $e)
        {
            return Redirect::to(str_replace('/work-experiences', '', $request->path()))->with('danger', 'Unable to add record to the database.');
        }

        return Redirect::to(str_replace('/work-experiences', '', $request->path()))->with('success', 'Record successfully added.');
    }

    /**
     * Update the Profile - Qualifications - Work Experiences.
     *
     * @Patch("profile/qualifications/work-experiences")
     * @Patch("pim/employee-list/{id}/qualifications/work-experiences")
     *
     * @param QualificationsWorkExperienceRequest $request
     * @param WorkExperience $workExperience
     * @return
     */
    public function updateWorkExperience(QualificationsWorkExperienceRequest $request, WorkExperience $workExperience, $employee_id = null)
    {
        $workExperience = $workExperience->whereId($request->get('work_experience_id'))->first();

        if ( ! $workExperience)
        {
            return Redirect::to(str_replace('/work-experiences', '', $request->path()))->with('danger', 'Unable to retrieve record from database.');
        }

        try
        {
            $workExperience->company = $request->get('company');
            $workExperience->job_title = $request->get('job_title');
            $workExperience->from_date = $request->get('from_date') ? $request->get('from_date') : null;
            $workExperience->to_date = $request->get('to_date') ? $request->get('to_date') : null;
            $workExperience->comment = $request->get('comment');

            $workExperience->save();
        } catch (Exception $e)
        {
            return Redirect::to(str_replace('/work-experiences', '', $request->path()))->with('danger', 'Unable to update record.');
        }

        return Redirect::to(str_replace('/work-experiences', '', $request->path()))->with('success', 'Record successfully updated.');

    }

    /**
     * Save the Profile - Qualifications - Education.
     *
     * @Post("profile/qualifications/educations")
     * @Post("pim/employee-list/{id}/qualifications/educations")
     *
     * @param QualificationsEducationRequest $request
     * @param Education $education
     * @return
     */
    public function saveEducation(QualificationsEducationRequest $request, Education $education)
    {
        try
        {
            $education->employee_id = $request->get('id');
            $education->education_level_id = $request->get('education_level_id');
            $education->institute = $request->get('institute');
            $education->major_specialization = $request->get('major_specialization');
            $education->from_date = $request->get('from_date') ? $request->get('from_date') : null;
            $education->to_date = $request->get('to_date') ? $request->get('to_date') : null;
            $education->gpa_score = $request->get('gpa_score') ? $request->get('gpa_score') : null;

            $education->save();
        } catch (Exception $e)
        {
            return Redirect::to(str_replace('/educations', '', $request->path()))->with('danger', 'Unable to add record to the database.');
        }

        return Redirect::to(str_replace('/educations', '', $request->path()))->with('success', 'Record successfully added.');
    }

    /**
     * Update the Profile - Qualifications - Education.
     *
     * @Patch("profile/qualifications/educations")
     * @Patch("pim/employee-list/{id}/qualifications/educations")
     *
     * @param QualificationsEducationRequest $request
     * @param Education $education
     * @return
     */
    public function updateEducation(QualificationsEducationRequest $request, Education $education)
    {
        $education = $education->whereId($request->get('education_id'))->first();

        if ( ! $education)
        {
            return Redirect::to(str_replace('/educations', '', $request->path()))->with('danger', 'Unable to retrieve record from database.');
        }

        try
        {
            $education->employee_id = $request->get('id');
            $education->education_level_id = $request->get('education_level_id');
            $education->institute = $request->get('institute');
            $education->major_specialization = $request->get('major_specialization');
            $education->from_date = $request->get('from_date') ? $request->get('from_date') : null;
            $education->to_date = $request->get('to_date') ? $request->get('to_date') : null;
            $education->gpa_score = $request->get('gpa_score') ? $request->get('gpa_score') : null;

            $education->save();
        } catch (Exception $e)
        {
            return Redirect::to(str_replace('/educations', '', $request->path()))->with('danger', 'Unable to update record.');
        }

        return Redirect::to(str_replace('/educations', '', $request->path()))->with('success', 'Record successfully updated.');
    }

    /**
     * Save the Profile - Qualifications - Skills.
     *
     * @Post("profile/qualifications/skills")
     * @Post("pim/employee-list/{id}/qualifications/skills")
     *
     * @param QualificationsSkillRequest $request
     * @return
     */
    public function saveSkill(QualificationsSkillRequest $request)
    {
        try
        {
            $employee = $this->employee->whereId($request->get('id'))->first();

            $skill_id = $request->get('skill_id');
            $years_of_experience = $request->get('years_of_experience') ? $request->get('years_of_experience') : null;;;
            $comment = $request->get('skill_comment') ? $request->get('skill_comment') : null;;

            $employee->skills()->attach($skill_id, [
                'years_of_experience' => $years_of_experience,
                'comment'             => $comment
            ]);
        } catch (Exception $e)
        {
            return Redirect::to(str_replace('/skills', '', $request->path()))->with('danger', 'Unable to add record to the database.');
        }

        return Redirect::to(str_replace('/skills', '', $request->path()))->with('success', 'Record successfully added.');
    }

    /**
     * Update the Profile - Qualifications - Skills.
     *
     * @Patch("profile/qualifications/skills")
     * @Patch("pim/employee-list/{id}/qualifications/skills")
     *
     * @param QualificationsSkillRequest $request
     * @param EmployeeSkill $employeeSkill
     * @return
     */
    public function updateSkill(QualificationsSkillRequest $request, EmployeeSkill $employeeSkill)
    {
        $employeeSkill = $employeeSkill->whereId($request->get('employee_skill_id'))->first();

        if ( ! $employeeSkill)
        {
            return Redirect::to(str_replace('/skills', '', $request->path()))->with('danger', 'Unable to retrieve record from database.');
        }

        try
        {
            $employeeSkill->skill_id = $request->get('skill_id');
            $employeeSkill->years_of_experience = $request->get('years_of_experience') ? $request->get('years_of_experience') : null;;;
            $employeeSkill->comment = $request->get('skill_comment') ? $request->get('skill_comment') : null;;

            $employeeSkill->save();
        } catch (Exception $e)
        {
            return Redirect::to(str_replace('/skills', '', $request->path()))->with('danger', 'Unable to update record.');
        }

        return Redirect::to(str_replace('/skills', '', $request->path()))->with('success', 'Record successfully updated.');
    }
}
