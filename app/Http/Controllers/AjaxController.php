<?php

namespace HRis\Http\Controllers;

use Config;
use Exception;
use HRis\Eloquent\City;
use HRis\Eloquent\Education;
use HRis\Eloquent\EducationLevel;
use HRis\Eloquent\Employee;
use HRis\Eloquent\EmployeeSkill;
use HRis\Eloquent\EmployeeWorkShift;
use HRis\Eloquent\EmploymentStatus;
use HRis\Eloquent\JobHistory;
use HRis\Eloquent\JobTitle;
use HRis\Eloquent\Nationality;
use HRis\Eloquent\PayGrade;
use HRis\Eloquent\Skill;
use HRis\Eloquent\SSSContribution;
use HRis\Eloquent\TaxComputation;
use HRis\Eloquent\TerminationReason;
use HRis\Eloquent\WorkExperience;
use HRis\Eloquent\WorkShift;
use HRis\Http\Requests\Administration\EducationRequest;
use HRis\Http\Requests\Administration\EmploymentStatusRequest;
use HRis\Http\Requests\Administration\JobTitleRequest;
use HRis\Http\Requests\Administration\NationalityRequest;
use HRis\Http\Requests\Administration\PayGradeRequest;
use HRis\Http\Requests\Administration\SkillRequest;
use HRis\Http\Requests\Administration\WorkShiftRequest;
use HRis\Http\Requests\PIM\TerminationReasonsRequest;
use HRis\Http\Requests\Profile\JobRequest;
use HRis\Http\Requests\Profile\QualificationsEducationRequest;
use HRis\Http\Requests\Profile\QualificationsSkillRequest;
use HRis\Http\Requests\Profile\QualificationsWorkExperienceRequest;
use HRis\Http\Requests\Profile\SalaryRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;

/**
 * Class AjaxController
 * @package HRis\Http\Controllers
 *
 * @Middleware("auth")
 */
class AjaxController extends Controller
{

    /**
     * Show the profile personal details form.
     *
     * @Get("ajax/update-address")
     */
    public function updateAddress()
    {
        if (Request::ajax()) {

            $provinceId = Request::get('province_id');
            $cities = City::whereProvinceId($provinceId)->lists('name', 'id');

            $json = '';
            foreach ($cities as $key => $value) {
                $id = $key;
                $name = $value;

                $json[] = ['id' => $id, 'name' => $name];
            }

            print(json_encode($json));
        }
    }

    /**
     * Get the profile qualifications work experience.
     *
     * @Get("ajax/profile/qualifications/work-experience")
     * @Get("ajax/pim/employee-list/{id}/qualifications/work-experience")
     *
     * @param QualificationsWorkExperienceRequest $request
     */
    public function getWorkExperience(QualificationsWorkExperienceRequest $request)
    {
        if ($request->ajax()) {
            $workExperienceId = $request->get('id');

            try {
                $workExperience = WorkExperience::whereId($workExperienceId)->first();

                print(json_encode($workExperience));
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Delete the profile qualifications work experience.
     *
     * @Delete("ajax/profile/qualifications/work-experience")
     * @Delete("ajax/pim/employee-list/{id}/qualifications/work-experience")
     *
     * @param QualificationsWorkExperienceRequest $request
     */
    public function deleteWorkExperience(QualificationsWorkExperienceRequest $request)
    {
        if ($request->ajax()) {
            $workExperienceId = $request->get('id');

            try {
                WorkExperience::whereId($workExperienceId)->delete();

                print('success');
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Get the profile qualifications education.
     *
     * @Get("ajax/profile/qualifications/education")
     * @Get("ajax/pim/employee-list/{id}/qualifications/education")
     *
     * @param QualificationsEducationRequest $request
     */
    public function getEducation(QualificationsEducationRequest $request)
    {
        if ($request->ajax()) {
            $educationId = $request->get('id');

            try {
                $education = Education::whereId($educationId)->first();

                print(json_encode($education));
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Delete the profile qualifications education.
     *
     * @Delete("ajax/profile/qualifications/education")
     * @Delete("ajax/pim/employee-list/{id}/qualifications/education")
     *
     * @param QualificationsEducationRequest $request
     */
    public function deleteEduction(QualificationsEducationRequest $request)
    {
        if ($request->ajax()) {
            $educationId = $request->get('id');

            try {
                Education::whereId($educationId)->delete();

                print('success');
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Get the profile qualifications skill.
     *
     * @Get("ajax/profile/qualifications/skill")
     * @Get("ajax/pim/employee-list/{id}/qualifications/skill")
     *
     * @param QualificationsSkillRequest $request
     */
    public function getSkill(QualificationsSkillRequest $request)
    {
        if ($request->ajax()) {
            $employeeSkillId = $request->get('id');

            try {
                $skill = EmployeeSkill::whereId($employeeSkillId)->first();

                print(json_encode($skill));
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Delete the profile qualifications skill.
     *
     * @Delete("ajax/profile/qualifications/skill")
     * @Delete("ajax/pim/employee-list/{id}/qualifications/skill")
     *
     * @param QualificationsSkillRequest $request
     */
    public function deleteSkill(QualificationsSkillRequest $request)
    {
        if ($request->ajax()) {
            $employeeSkillId = $request->get('id');

            try {
                EmployeeSkill::whereId($employeeSkillId)->delete();

                print('success');
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Delete the profile qualifications skill.
     *
     * @Post("ajax/upload-profile-image")
     */
    public function uploadProfileImage()
    {
        if (Request::ajax()) {
            try {
                $employee = Employee::whereId(Request::get('employeeId'))->first();

                $img = Request::get('imageData');

                $filename = md5($img) . '.png';

                $path = public_path() . '/img/profile/' . $filename;

                File::put($path, file_get_contents($img));

                $employee->avatar = $filename;
                $employee->save();

                print($filename);
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Get the profile qualifications skill.
     *
     * @Get("ajax/get-termination-reason")
     *
     * @param TerminationReasonsRequest $request
     */
    public function getTerminationReason(TerminationReasonsRequest $request)
    {
        if ($request->ajax()) {
            $terminationReasonId = $request->get('id');

            try {
                $terminationReason = TerminationReason::whereId($terminationReasonId)->first();

                print(json_encode($terminationReason));
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Delete the profile qualifications skill.
     *
     * @Delete("ajax/delete-termination-reason")
     *
     * @param TerminationReasonsRequest $request
     */
    public function deleteTerminationReason(TerminationReasonsRequest $request)
    {
        if ($request->ajax()) {
            $terminationReasonId = $request->get('id');

            try {
                TerminationReason::whereId($terminationReasonId)->delete();

                print('success');
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Get the job title.
     *
     * @Get("ajax/get-job-title")
     *
     * @param JobTitleRequest $request
     */
    public function getJobTitle(JobTitleRequest $request)
    {
        if ($request->ajax()) {
            $jobTitleId = $request->get('id');

            try {
                $jobTitle = JobTitle::whereId($jobTitleId)->first();

                print(json_encode($jobTitle));
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Delete the job title.
     *
     * @Delete("ajax/delete-job-title")
     *
     * @param JobTitleRequest $request
     */
    public function deleteJobTitle(JobTitleRequest $request)
    {
        if ($request->ajax()) {
            $jobTitleId = $request->get('id');

            try {
                JobTitle::whereId($jobTitleId)->delete();

                print('success');
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Get the employment status.
     *
     * @Get("ajax/get-employment-status")
     *
     * @param EmploymentStatusRequest $request
     */
    public function getEmploymentStatus(EmploymentStatusRequest $request)
    {
        if ($request->ajax()) {
            $employmentStatusId = $request->get('id');

            try {
                $employmentStatus = EmploymentStatus::whereId($employmentStatusId)->first();

                print(json_encode($employmentStatus));
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Delete the employment status.
     *
     * @Delete("ajax/delete-employment-status")
     *
     * @param EmploymentStatusRequest $request
     */
    public function deleteEmploymentStatus(EmploymentStatusRequest $request)
    {
        if ($request->ajax()) {
            $employmentStatusId = $request->get('id');

            try {
                EmploymentStatus::whereId($employmentStatusId)->delete();

                print('success');
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Get the nationality.
     *
     * @Get("ajax/get-nationality")
     *
     * @param NationalityRequest $request
     */
    public function getNationality(NationalityRequest $request)
    {
        if ($request->ajax()) {
            $nationalityId = $request->get('id');

            try {
                $nationality = Nationality::whereId($nationalityId)->first();

                print(json_encode($nationality));
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Delete the nationality.
     *
     * @Delete("ajax/delete-nationality")
     *
     * @param NationalityRequest $request
     */
    public function deleteNationality(NationalityRequest $request)
    {
        if ($request->ajax()) {
            $nationalityId = $request->get('id');

            try {
                Nationality::whereId($nationalityId)->delete();

                print('success');
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Get the employment status.
     *
     * @Get("ajax/get-work-shift")
     *
     * @param WorkShiftRequest $request
     */
    public function getWorkShift(WorkShiftRequest $request)
    {
        if ($request->ajax()) {
            $workShiftId = $request->get('id');

            try {
                $workShift = WorkShift::whereId($workShiftId)->first();

                print(json_encode($workShift));
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Delete the nationality.
     *
     * @Delete("ajax/delete-work-shift")
     *
     * @param WorkShiftRequest $request
     */
    public function deleteWorkShift(WorkShiftRequest $request)
    {
        if ($request->ajax()) {
            $workShiftId = $request->get('id');

            try {
                WorkShift::whereId($workShiftId)->delete();

                print('success');
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Get the employment status.
     *
     * @Get("ajax/get-pay-grade")
     *
     * @param PayGradeRequest $request
     */
    public function getPayGrade(PayGradeRequest $request)
    {
        if ($request->ajax()) {
            $payGradeId = $request->get('id');

            try {
                $payGrade = PayGrade::whereId($payGradeId)->first();

                print(json_encode($payGrade));
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Delete the nationality.
     *
     * @Delete("ajax/delete-pay-grade")
     *
     * @param PayGradeRequest $request
     */
    public function deletePayGrade(PayGradeRequest $request)
    {
        if ($request->ajax()) {
            $payGradeId = $request->get('id');

            try {
                PayGrade::whereId($payGradeId)->delete();

                print('success');
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Get the skill.
     *
     * @Get("ajax/get-skill")
     *
     * @param SkillRequest $request
     */
    public function getAdminSkill(SkillRequest $request)
    {
        if ($request->ajax()) {
            $skillId = $request->get('id');

            try {
                $skill = Skill::whereId($skillId)->first();

                print(json_encode($skill));
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Delete the skill.
     *
     * @Delete("ajax/delete-skill")
     *
     * @param SkillRequest $request
     */
    public function deleteAdminSkill(SkillRequest $request)
    {
        if ($request->ajax()) {
            $skillId = $request->get('id');

            try {
                Skill::whereId($skillId)->delete();

                print('success');
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Get the education.
     *
     * @Get("ajax/get-education")
     *
     * @param EducationRequest $request
     */
    public function getAdminEducation(EducationRequest $request)
    {
        if ($request->ajax()) {
            $educationId = $request->get('id');

            try {
                $education = EducationLevel::whereId($educationId)->first();

                print(json_encode($education));
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Delete the education.
     *
     * @Delete("ajax/delete-education")
     *
     * @param EducationRequest $request
     */
    public function deleteAdminEducation(EducationRequest $request)
    {
        if ($request->ajax()) {
            $educationId = $request->get('id');

            try {
                EducationLevel::whereId($educationId)->delete();

                print('success');
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * Delete the profile job details.
     *
     * @Delete("ajax/profile/job/edit")
     * @Delete("ajax/pim/employee-list/{id}/job/edit")
     *
     * @param JobRequest $request
     */
    public function deleteJobHistory(JobRequest $request)
    {
        if ($request->ajax()) {
            $jobHistoryId = $request->get('id');

            try {
                JobHistory::whereId($jobHistoryId)->delete();

                print('success');
            } catch (Exception $e) {
                print('failed');
            }

        }
    }

    /**
     * get the profile tax salary details.
     *
     * @Get("ajax/profile/salary/edit")
     * @Get("ajax/profile/salary")
     * @Get("ajax/pim/employee-list/{id}/salary")
     * @Get("ajax/pim/employee-list/{id}/salary/edit")
     *
     * @param SalaryRequest $request
     */
    public function updateSalary(SalaryRequest $request)
    {
        if ($request->ajax()) {
            $mode = Config::get('salary.semi_monthly');
            $semiMonthly = $request->get('salary') / $mode;
            $status = $request->get('status');
            $sss = $request->get('sss');
            $taxableSalary = $semiMonthly - $request->get('deductions');

            try {
                if ($request->get('type') == 'sss') {
                    $getSSS = SSSContribution::where('range_compensation_from', '<=', $semiMonthly)
                        ->orderBy('range_compensation_from', 'desc')
                        ->first();
                    $deductions = ($request->get('deductions') - $sss) + $getSSS->sss_ee;
                    $sss = $getSSS->sss_ee;
                    $taxableSalary = $semiMonthly - $deductions;
                } else {
                    $taxableSalary = $semiMonthly - $request->get('deductions');
                }
                $taxes = TaxComputation::getTaxRate($status, $taxableSalary);

                $over = 0;

                if ($taxableSalary > $taxes->$status) {
                    $over = $taxableSalary - $taxes->$status;
                }

                $totalTax = $taxes->exemption + ($over * $taxes->percentage_over);
                $return = json_encode(['tax' => $totalTax, 'sss' => $sss, 'salary' => $semiMonthly]);

                print($return);

            } catch (Exception $e) {

            }
        }
    }

    /**
     * Delete the profile work-shift details.
     *
     * @Delete("ajax/profile/work-shifts/edit")
     * @Delete("ajax/pim/employee-list/{id}/work-shifts/edit")
     *
     * @param WorkShiftRequest $request
     */
    public function deleteWorkShiftData(WorkShiftRequest $request)
    {
        if ($request->ajax()) {
            $WorkShiftId = $request->get('id');

            try {
                EmployeeWorkShift::whereId($WorkShiftId)->delete();

                print('success');
            } catch (Exception $e) {
                print('failed');
            }

        }
    }
}
