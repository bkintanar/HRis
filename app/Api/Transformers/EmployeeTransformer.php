<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Transformers;

use HRis\Api\Eloquent\Employee;
use League\Fractal\TransformerAbstract;

class EmployeeTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include.
     *
     * @var array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    protected $defaultIncludes = [
        'user',
        'job_history',
    ];

    /**
     * Resources that can be included if requested.
     *
     * @var array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    protected $availableIncludes = [
        'city',
        'country',
        'dependents',
        'emergency_contacts',
        'job_histories',
        'work_experiences',
        'employee_skills',
        'educations',
        'custom_field_values',
    ];

    /**
     * Transform object into a generic array.
     *
     * @param Employee $employee
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function transform(Employee $employee)
    {
        return [
            'id'                  => $employee->id,
            'employee_id'         => $employee->employee_id,
            'face_id'             => $employee->face_id,
            'marital_status_id'   => $employee->marital_status_id,
            'nationality_id'      => $employee->nationality_id,
            'first_name'          => $employee->first_name,
            'middle_name'         => $employee->middle_name,
            'last_name'           => $employee->last_name,
            'sufffix_name'        => $employee->sufffix_name,
            'avatar'              => $employee->avatar,
            'gender'              => $employee->gender,
            'address_1'           => $employee->address_1,
            'address_2'           => $employee->address_2,
            'address_city_id'     => (int) $employee->address_city_id,
            'address_province_id' => (int) $employee->address_province_id,
            'address_country_id'  => (int) $employee->address_country_id,
            'address_postal_code' => $employee->address_postal_code,
            'home_phone'          => $employee->home_phone,
            'mobile_phone'        => $employee->mobile_phone,
            'work_email'          => $employee->work_email,
            'other_email'         => $employee->other_email,
            'social_security'     => $employee->social_security,
            'tax_identification'  => $employee->tax_identification,
            'philhealth'          => $employee->philhealth,
            'hdmf_pagibig'        => $employee->hdmf_pagibig,
            'mid_rtn'             => $employee->mid_rtn,
            'birth_date'          => $employee->birth_date,
            'remarks'             => $employee->remarks,
            'joined_date'         => $employee->joined_date,
            'probation_end_date'  => $employee->probation_end_date,
            'permanency_date'     => $employee->permanency_date,
            'resign_date'         => $employee->resign_date,
        ];
    }

    /**
     * Include City.
     *
     * @param Employee $employee
     *
     * @return \League\Fractal\Resource\Item
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeCity(Employee $employee)
    {
        $city = $employee->city;

        return $this->item($city, new CityTransformer());
    }

    /**
     * Include User.
     *
     * @param Employee $employee
     *
     * @return \League\Fractal\Resource\Item
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeUser(Employee $employee)
    {
        $user = $employee->user;

        return $this->item($user, new UserTransformer());
    }

    /**
     * Include Country.
     *
     * @param Employee $employee
     *
     * @return \League\Fractal\Resource\Item
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeCountry(Employee $employee)
    {
        $country = $employee->country;

        return $this->item($country, new CountryTransformer());
    }

    /**
     * Include Dependent.
     *
     * @param Employee $employee
     *
     * @return \League\Fractal\Resource\Collection
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeDependents(Employee $employee)
    {
        $dependents = $employee->dependents;

        return $this->collection($dependents, new DependentTransformer());
    }

    /**
     * Include EmergencyContact.
     *
     * @param Employee $employee
     *
     * @return \League\Fractal\Resource\Collection
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeEmergencyContacts(Employee $employee)
    {
        $emergency_contacts = $employee->emergencyContacts;

        return $this->collection($emergency_contacts, new EmergencyContactTransformer());
    }

    /**
     * Include CustomFieldValue.
     *
     * @param Employee $employee
     *
     * @return \League\Fractal\Resource\Collection
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeCustomFieldValues(Employee $employee)
    {
        $custom_field_values = $employee->customFieldValues;

        return $this->collection($custom_field_values, new CustomFieldValueTransformer());
    }

    /**
     * Include JobHistory.
     *
     * @param Employee $employee
     *
     * @return \League\Fractal\Resource\Collection
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeJobHistory(Employee $employee)
    {
        $job_history = $employee->jobHistory();

        return $this->item($job_history, new JobHistoryTransformer());
    }

    /**
     * Include JobHistories.
     *
     * @param Employee $employee
     *
     * @return \League\Fractal\Resource\Collection
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeJobHistories(Employee $employee)
    {
        $job_histories = $employee->jobHistories()->get();

        return $this->collection($job_histories, new JobHistoryTransformer());
    }

    /**
     * Include WorkExperiences.
     *
     * @param Employee $employee
     *
     * @return \League\Fractal\Resource\Collection
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeWorkExperiences(Employee $employee)
    {
        $work_experiences = $employee->workExperiences()->get();

        return $this->collection($work_experiences, new WorkExperienceTransformer());
    }

    /**
     * Include EmployeeSkills.
     *
     * @param Employee $employee
     *
     * @return \League\Fractal\Resource\Collection
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeEmployeeSkills(Employee $employee)
    {
        $employee_skills = $employee->employeeSkills()->get();

        return $this->collection($employee_skills, new EmployeeSkillTransformer());
    }

    /**
     * Include Educations.
     *
     * @param Employee $employee
     *
     * @return \League\Fractal\Resource\Collection
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeEducations(Employee $employee)
    {
        $educations = $employee->educations()->get();

        return $this->collection($educations, new EducationTransformer());
    }
}
