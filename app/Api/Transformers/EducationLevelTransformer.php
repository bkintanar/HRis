<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Transformers;

use HRis\Api\Eloquent\EducationLevel;
use League\Fractal\TransformerAbstract;

class EducationLevelTransformer extends TransformerAbstract
{
    /**
     * Transform object into a generic array.
     *
     * @param EducationLevel $education_level
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function transform(EducationLevel $education_level)
    {
        return [
            'id'   => (int) $education_level->id,
            'name' => $education_level->name,
        ];
    }
}
