<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Transformers;

use HRis\Api\Eloquent\EmployeeSkill;

class EmployeeSkillTransformer extends BaseTransformer
{
    /**
     * Transform object into a generic array.
     *
     * @param EmployeeSkill $skill
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function transform(EmployeeSkill $skill)
    {
        return [
            'id'                  => (int) $skill->id,
            'employee_id'         => (int) $skill->employee_id,
            'skill_id'            => $skill->skill_id,
            'years_of_experience' => $skill->years_of_experience,
            'comment'             => $skill->comment,
        ];
    }
}
