<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Transformers;

use DateTime;
use HRis\Api\Eloquent\Education;
use League\Fractal\TransformerAbstract;

class EducationTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include.
     *
     * @var array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    protected $defaultIncludes = [];

    /**
     * Transform object into a generic array.
     *
     * @param Education $education
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function transform(Education $education)
    {
        $from_date = new DateTime($education->from_date);
        $to_date = new DateTime($education->to_date);

        return [
            'id'                   => (int) $education->id,
            'employee_id'          => (int) $education->employee_id,
            'education_level_id'   => (int) $education->education_level_id,
            'institute'            => $education->institute,
            'major_specialization' => $education->major_specialization,
            'from_date'            => $education->from_date,
            'to_date'              => $education->to_date,
            'diff_date'            => $to_date->diff($from_date),
            'gpa_score'            => $education->gpa_score,
        ];
    }

    /**
     * Include Employee.
     *
     * @param Education $education
     *
     * @return \League\Fractal\Resource\Item
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeEmployee(Education $education)
    {
        $employee = $education->employee;

        return $this->item($employee, new EmployeeTransformer());
    }

    /**
     * Include EducationLevel.
     *
     * @param Education $education
     *
     * @return \League\Fractal\Resource\Item
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeEducationLevel(Education $education)
    {
        $education_level = $education->educationLevel;

        return $this->item($education_level, new EducationLevelTransformer());
    }
}
