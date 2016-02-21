<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Transformers;

use HRis\Api\Eloquent\JobTitle;
use League\Fractal\TransformerAbstract;

class JobTitleTransformer extends TransformerAbstract
{
    /**
     * Transform object into a generic array.
     *
     * @param JobTitle $job_title
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function transform(JobTitle $job_title)
    {
        return [
            'id'          => (int) $job_title->id,
            'name'        => $job_title->name,
            'description' => $job_title->description,
        ];
    }
}
