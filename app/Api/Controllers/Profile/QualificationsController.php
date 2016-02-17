<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Controllers\Profile;

use Exception;
use HRis\Api\Controllers\BaseController;
use HRis\Api\Eloquent\CustomFieldSection;
use HRis\Api\Eloquent\Education;
use HRis\Api\Eloquent\Employee;
use HRis\Api\Eloquent\EmployeeSkill;
use HRis\Api\Eloquent\Navlink;
use HRis\Api\Eloquent\WorkExperience;
use HRis\Api\Requests\Profile\QualificationsEducationRequest;
use HRis\Api\Requests\Profile\QualificationsSkillRequest;
use HRis\Api\Requests\Profile\QualificationsWorkExperienceRequest;

/**
 * Class QualificationsController.
 */
class QualificationsController extends BaseController
{
    /**
     * @var Employee
     */
    protected $employee;

    /**
     * @param Employee $employee
     */
    public function __construct(Employee $employee)
    {
        $this->employee = $employee;

        $profile_details_id = Navlink::whereName('Qualifications')->value('id');
        $this->data['custom_field_sections'] = CustomFieldSection::whereScreenId($profile_details_id)->get();
    }

    /**
     * Save the Profile - Qualifications - Work Experiences.
     *
     * @param QualificationsWorkExperienceRequest $request
     * @param WorkExperience                      $work_experience
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function storeWorkExperience(QualificationsWorkExperienceRequest $request, WorkExperience $work_experience)
    {
        return $this->storeModel($request, $work_experience, 'work_experience');
    }

    /**
     * Delete the Profile - Qualifications - Work Experiences.
     *
     * @param QualificationsWorkExperienceRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function destroyWorkExperience(QualificationsWorkExperienceRequest $request, WorkExperience $work_experience)
    {
        return $this->destroyModel($request, $work_experience);
    }

    /**
     * Update the Profile - Qualifications - Work Experiences.
     *
     * @param QualificationsWorkExperienceRequest $request
     * @param WorkExperience                      $workExperience
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function updateWorkExperience(QualificationsWorkExperienceRequest $request, WorkExperience $workExperience)
    {
        $workExperience = $workExperience->whereId($request->get('work_experience_id'))->first();

        if (!$workExperience) {
            return $this->responseAPI(404, UNABLE_RETRIEVE_MESSAGE);
        }

        try {
            $workExperience->update($request->all());
        } catch (Exception $e) {
            return $this->responseAPI(422, UNABLE_UPDATE_MESSAGE);
        }

        return $this->responseAPI(200, SUCCESS_UPDATE_MESSAGE);
    }

    /**
     * Save the Profile - Qualifications - Education.
     *
     * @param QualificationsEducationRequest $request
     * @param Education                      $education
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function storeEducation(QualificationsEducationRequest $request, Education $education)
    {
        return $this->storeModel($request, $education, 'education');
    }

    /**
     * Delete the Profile - Qualifications - Educations.
     *
     * @param QualificationsEducationRequest $request
     * @param Education                      $education
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function destroyEducation(QualificationsEducationRequest $request, Education $education)
    {
        return $this->destroyModel($request, $education);
    }

    /**
     * Update the Profile - Qualifications - Education.
     *
     * @param QualificationsEducationRequest $request
     * @param Education                      $education
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function updateEducation(QualificationsEducationRequest $request, Education $education)
    {
        $education = $education->whereId($request->get('education_id'))->first();

        if (!$education) {
            return $this->responseAPI(404, UNABLE_RETRIEVE_MESSAGE);
        }

        try {
            $education->update($request->except(['education_level', 'education_levels']));
        } catch (Exception $e) {
            return $this->responseAPI(422, UNABLE_UPDATE_MESSAGE);
        }

        return $this->responseAPI(200, SUCCESS_UPDATE_MESSAGE);
    }

    /**
     * Save the Profile - Qualifications - Skills.
     *
     * @param QualificationsSkillRequest $request
     * @param EmployeeSkill              $employee_skill
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function storeSkill(QualificationsSkillRequest $request, EmployeeSkill $employee_skill)
    {
        try {
            $employee = $this->employee->whereId($request->get('employee_id'))->first();

            $skill_id = $request->get('skill_id');
            $years_of_experience = $request->get('years_of_experience') || null;
            $comment = $request->get('comment') || null;

            $employee->skills()->attach($skill_id, [
                'years_of_experience' => $years_of_experience,
                'comment'             => $comment,
            ]);
        } catch (Exception $e) {
            return $this->responseAPI(422, UNABLE_ADD_MESSAGE);
        }

        $skill = $employee_skill::whereEmployeeId($employee->id)->orderBy('id', 'desc')->first();

        return $this->responseAPI(201, SUCCESS_ADD_MESSAGE, compact('skill'));
    }

    /**
     * Update the Profile - Qualifications - Skills.
     *
     * @param QualificationsSkillRequest $request
     * @param EmployeeSkill              $employeeSkill
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function updateSkill(QualificationsSkillRequest $request, EmployeeSkill $employeeSkill)
    {
        $employeeSkill = $employeeSkill->whereId($request->get('id'))->first();

        if (!$employeeSkill) {
            return $this->responseAPI(404, UNABLE_RETRIEVE_MESSAGE);
        }

        try {
            $employeeSkill->skill_id = $request->get('skill_id');
            $employeeSkill->years_of_experience = $request->get('years_of_experience') ?: null;
            $employeeSkill->comment = $request->get('comment') ?: null;

            $employeeSkill->save();
        } catch (Exception $e) {
            return $this->responseAPI(422, UNABLE_UPDATE_MESSAGE);
        }

        return $this->responseAPI(200, SUCCESS_UPDATE_MESSAGE);
    }

    /**
     * Delete the Profile - Qualifications - Skills.
     *
     * @param QualificationsSkillRequest $request
     * @param EmployeeSkill              $employee_skill
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function destroySkill(QualificationsSkillRequest $request, EmployeeSkill $employee_skill)
    {
        return $this->destroyModel($request, $employee_skill);
    }
}
