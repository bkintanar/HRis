<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Http\Controllers\Profile;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use HRis\Eloquent\CustomFieldSection;
use HRis\Eloquent\Education;
use HRis\Eloquent\Employee;
use HRis\Eloquent\EmployeeSkill;
use HRis\Eloquent\Navlink;
use HRis\Eloquent\WorkExperience;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Profile\QualificationsEducationRequest;
use HRis\Http\Requests\Profile\QualificationsRequest;
use HRis\Http\Requests\Profile\QualificationsSkillRequest;
use HRis\Http\Requests\Profile\QualificationsWorkExperienceRequest;

/**
 * Class QualificationsController.
 *
 * @Middleware("auth")
 */
class QualificationsController extends Controller
{
    /**
     * @var Employee
     */
    protected $employee;

    /**
     * @param Sentinel $auth
     * @param Employee $employee
     */
    public function __construct(Sentinel $auth, Employee $employee)
    {
        parent::__construct($auth);

        $this->employee = $employee;

        $profile_details_id = Navlink::whereName('Qualifications')->pluck('id');
        $this->data['custom_field_sections'] = CustomFieldSection::whereScreenId($profile_details_id)->get();
    }

    /**
     * Show the Profile - Qualifications.
     *
     * @Get("profile/qualifications")
     * @Get("pim/employee-list/{id}/qualifications")
     *
     * @param QualificationsRequest $request
     * @param null                  $employee_id
     *
     * @return \Illuminate\View\View
     *
     * @author Bertrand Kintanar
     */
    public function index(QualificationsRequest $request, $employee_id = null)
    {
        $employee = $this->employee->getEmployeeById($employee_id, $this->logged_user->id);

        if (!$employee) {
            return response()->make(view()->make('errors.404'), 404);
        }

        $this->data['employee'] = $employee;

        $this->data['workExperiences'] = $employee->workExperiences;
        $this->data['educations'] = $employee->educations;
        $this->data['skills'] = $employee->skills;

        $this->data['pim'] = $request->is('*pim/*') ?: false;
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
     * @param WorkExperience                      $workExperience
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar
     */
    public function storeWorkExperience(QualificationsWorkExperienceRequest $request, WorkExperience $workExperience)
    {
        try {
            $workExperience->create($request->all());
        } catch (Exception $e) {
            return redirect()->to(str_replace('/work-experiences', '', $request->path()))->with('danger',
                UNABLE_ADD_MESSAGE);
        }

        return redirect()->to(str_replace('/work-experiences', '', $request->path()))->with('success',
            SUCCESS_ADD_MESSAGE);
    }

    /**
     * Update the Profile - Qualifications - Work Experiences.
     *
     * @Patch("profile/qualifications/work-experiences")
     * @Patch("pim/employee-list/{id}/qualifications/work-experiences")
     *
     * @param QualificationsWorkExperienceRequest $request
     * @param WorkExperience                      $workExperience
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar
     */
    public function updateWorkExperience(QualificationsWorkExperienceRequest $request, WorkExperience $workExperience)
    {
        $workExperience = $workExperience->whereId($request->get('work_experience_id'))->first();

        if (!$workExperience) {
            return redirect()->to(str_replace('/work-experiences', '', $request->path()))->with('danger',
                UNABLE_RETRIEVE_MESSAGE);
        }

        try {
            $workExperience->update($request->all());
        } catch (Exception $e) {
            return redirect()->to(str_replace('/work-experiences', '', $request->path()))->with('danger',
                UNABLE_UPDATE_MESSAGE);
        }

        return redirect()->to(str_replace('/work-experiences', '', $request->path()))->with('success',
            SUCCESS_UPDATE_MESSAGE);
    }

    /**
     * Save the Profile - Qualifications - Education.
     *
     * @Post("profile/qualifications/educations")
     * @Post("pim/employee-list/{id}/qualifications/educations")
     *
     * @param QualificationsEducationRequest $request
     * @param Education                      $education
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar
     */
    public function storeEducation(QualificationsEducationRequest $request, Education $education)
    {
        try {
            $education->create($request->all());
        } catch (Exception $e) {
            return redirect()->to(str_replace('/educations', '', $request->path()))->with('danger', UNABLE_ADD_MESSAGE);
        }

        return redirect()->to(str_replace('/educations', '', $request->path()))->with('success', SUCCESS_ADD_MESSAGE);
    }

    /**
     * Update the Profile - Qualifications - Education.
     *
     * @Patch("profile/qualifications/educations")
     * @Patch("pim/employee-list/{id}/qualifications/educations")
     *
     * @param QualificationsEducationRequest $request
     * @param Education                      $education
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar
     */
    public function updateEducation(QualificationsEducationRequest $request, Education $education)
    {
        $education = $education->whereId($request->get('education_id'))->first();

        if (!$education) {
            return redirect()->to(str_replace('/educations', '', $request->path()))->with('danger',
                UNABLE_RETRIEVE_MESSAGE);
        }

        try {
            $education->update($request->all());
        } catch (Exception $e) {
            return redirect()->to(str_replace('/educations', '', $request->path()))->with('danger',
                UNABLE_UPDATE_MESSAGE);
        }

        return redirect()->to(str_replace('/educations', '', $request->path()))->with('success',
            SUCCESS_UPDATE_MESSAGE);
    }

    /**
     * Save the Profile - Qualifications - Skills.
     *
     * @Post("profile/qualifications/skills")
     * @Post("pim/employee-list/{id}/qualifications/skills")
     *
     * @param QualificationsSkillRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar
     */
    public function storeSkill(QualificationsSkillRequest $request)
    {
        try {
            $employee = $this->employee->whereId($request->get('id'))->first();

            $skill_id = $request->get('skill_id');
            $years_of_experience = $request->get('years_of_experience') or null;
            $comment = $request->get('skill_comment') or null;

            $employee->skills()->attach($skill_id, [
                'years_of_experience' => $years_of_experience,
                'comment'             => $comment,
            ]);
        } catch (Exception $e) {
            return redirect()->to(str_replace('/skills', '', $request->path()))->with('danger', UNABLE_ADD_MESSAGE);
        }

        return redirect()->to(str_replace('/skills', '', $request->path()))->with('success', SUCCESS_ADD_MESSAGE);
    }

    /**
     * Update the Profile - Qualifications - Skills.
     *
     * @Patch("profile/qualifications/skills")
     * @Patch("pim/employee-list/{id}/qualifications/skills")
     *
     * @param QualificationsSkillRequest $request
     * @param EmployeeSkill              $employeeSkill
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar
     */
    public function updateSkill(QualificationsSkillRequest $request, EmployeeSkill $employeeSkill)
    {
        $employeeSkill = $employeeSkill->whereId($request->get('employee_skill_id'))->first();

        if (!$employeeSkill) {
            return redirect()->to(str_replace('/skills', '', $request->path()))->with('danger',
                UNABLE_RETRIEVE_MESSAGE);
        }

        try {
            $employeeSkill->skill_id = $request->get('skill_id');
            $employeeSkill->years_of_experience = $request->get('years_of_experience') ?: null;
            $employeeSkill->comment = $request->get('skill_comment') ?: null;

            $employeeSkill->save();
        } catch (Exception $e) {
            return redirect()->to(str_replace('/skills', '', $request->path()))->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        return redirect()->to(str_replace('/skills', '', $request->path()))->with('success', SUCCESS_UPDATE_MESSAGE);
    }
}
