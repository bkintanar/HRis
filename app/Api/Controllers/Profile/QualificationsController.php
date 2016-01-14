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

        $profile_details_id = Navlink::whereName('Qualifications')->pluck('id');
        $this->data['custom_field_sections'] = CustomFieldSection::whereScreenId($profile_details_id)->get();
    }

    /**
     * Save the Profile - Qualifications - Work Experiences.
     *
     * @param QualificationsWorkExperienceRequest $request
     * @param WorkExperience                      $workExperience
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function storeWorkExperience(QualificationsWorkExperienceRequest $request, WorkExperience $workExperience)
    {
        try {
            $work_experience = $workExperience->create($request->all());
        } catch (Exception $e) {
            return $this->response()->array(['message' => UNABLE_ADD_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        return $this->response()->array(['work_experience' => $work_experience, 'message' => SUCCESS_ADD_MESSAGE, 'status_code' => 201])->statusCode(201);
    }

    /**
     * Delete the Profile - Qualifications - Work Experiences.
     *
     * @param QualificationsWorkExperienceRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function destroyWorkExperience(QualificationsWorkExperienceRequest $request, WorkExperience $workExperience)
    {
        $work_experience_id = $request->get('id');

        try {
            $workExperience->whereId($work_experience_id)->delete();
        } catch (Exception $e) {
            return $this->response()->array(['message' => UNABLE_DELETE_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        return $this->response()->array(['message' => SUCCESS_DELETE_MESSAGE, 'status_code' => 200])->statusCode(200);
    }

    /**
     * Update the Profile - Qualifications - Work Experiences.
     *
     * @param QualificationsWorkExperienceRequest $request
     * @param WorkExperience                      $workExperience
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function updateWorkExperience(QualificationsWorkExperienceRequest $request, WorkExperience $workExperience)
    {
        $workExperience = $workExperience->whereId($request->get('work_experience_id'))->first();

        if (!$workExperience) {
            return $this->response()->array(['message' => UNABLE_RETRIEVE_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        try {
            $workExperience->update($request->all());
        } catch (Exception $e) {
            return $this->response()->array(['message' => UNABLE_UPDATE_MESSAGE, 'status_code' => 200])->statusCode(422);
        }

        return $this->response()->array(['message' => SUCCESS_UPDATE_MESSAGE, 'status_code' => 200])->statusCode(200);
    }

    /**
     * Save the Profile - Qualifications - Education.
     *
     * @param QualificationsEducationRequest $request
     * @param Education                      $education
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function storeEducation(QualificationsEducationRequest $request, Education $education)
    {
        try {
            $education = $education->create($request->except(['education_level', 'education_levels']));
        } catch (Exception $e) {
            return $this->response()->array(['message' => UNABLE_ADD_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        return $this->response()->array(['education' => $education, 'message' => SUCCESS_ADD_MESSAGE, 'status_code' => 201])->statusCode(201);
    }

    /**
     * Delete the Profile - Qualifications - Educations.
     *
     * @param QualificationsEducationRequest $request
     * @param Education                      $education
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function destroyEducation(QualificationsEducationRequest $request, Education $education)
    {
        $education_id = $request->get('id');

        try {
            $education->whereId($education_id)->delete();
        } catch (Exception $e) {
            return $this->response()->array(['message' => UNABLE_DELETE_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        return $this->response()->array(['message' => SUCCESS_DELETE_MESSAGE, 'status_code' => 200])->statusCode(200);
    }

    /**
     * Update the Profile - Qualifications - Education.
     *
     * @param QualificationsEducationRequest $request
     * @param Education                      $education
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function updateEducation(QualificationsEducationRequest $request, Education $education)
    {
        $education = $education->whereId($request->get('education_id'))->first();

        if (!$education) {
            return $this->response()->array(['message' => UNABLE_RETRIEVE_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        try {
            $education->update($request->except(['education_level', 'education_levels']));
        } catch (Exception $e) {
            return $this->response()->array(['message' => UNABLE_UPDATE_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        return $this->response()->array(['message' => SUCCESS_UPDATE_MESSAGE, 'status_code' => 200])->statusCode(200);
    }

    /**
     * Save the Profile - Qualifications - Skills.
     *
     * @param QualificationsSkillRequest $request
     * @param EmployeeSkill              $employee_skill
     *
     * @return \Illuminate\Http\RedirectResponse
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
            return $this->response()->array(['message' => UNABLE_ADD_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        $skill = $employee_skill::whereEmployeeId($employee->id)->orderBy('id', 'desc')->first();

        return $this->response()->array(['skill' => $skill, 'message' => SUCCESS_ADD_MESSAGE, 'status_code' => 201])->statusCode(201);
    }

    /**
     * Update the Profile - Qualifications - Skills.
     *
     * @param QualificationsSkillRequest $request
     * @param EmployeeSkill              $employeeSkill
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function updateSkill(QualificationsSkillRequest $request, EmployeeSkill $employeeSkill)
    {
        $employeeSkill = $employeeSkill->whereId($request->get('id'))->first();

        if (!$employeeSkill) {
            return $this->response()->array(['message' => UNABLE_RETRIEVE_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        try {
            $employeeSkill->skill_id = $request->get('skill_id');
            $employeeSkill->years_of_experience = $request->get('years_of_experience') ?: null;
            $employeeSkill->comment = $request->get('comment') ?: null;

            $employeeSkill->save();
        } catch (Exception $e) {
            return $this->response()->array(['message' => UNABLE_UPDATE_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        return $this->response()->array(['message' => SUCCESS_UPDATE_MESSAGE, 'status_code' => 200])->statusCode(200);
    }

    /**
     * Delete the Profile - Qualifications - Skills.
     *
     * @param QualificationsSkillRequest $request
     * @param EmployeeSkill              $employee_skill
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function destroySkill(QualificationsSkillRequest $request, EmployeeSkill $employee_skill)
    {
        $employee_skill_id = $request->get('id');

        try {
            $employee_skill->whereId($employee_skill_id)->delete();
        } catch (Exception $e) {
            return $this->response()->array(['message' => UNABLE_DELETE_MESSAGE, 'status_code' => 422])->statusCode(422);
        }

        return $this->response()->array(['message' => SUCCESS_DELETE_MESSAGE, 'status_code' => 200])->statusCode(200);
    }
}
