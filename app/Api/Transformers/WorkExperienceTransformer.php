<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Transformers;

use Carbon\Carbon;
use HRis\Api\Eloquent\WorkExperience;

class WorkExperienceTransformer extends BaseTransformer
{
    /**
     * Transform object into a generic array.
     *
     * @param WorkExperience $work_experience
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function transform(WorkExperience $work_experience)
    {
        $from_date = Carbon::parse($work_experience->from_date);
        $to_date = Carbon::parse($work_experience->to_date);

        $diff = $from_date->diffForHumans($to_date);

        return [
            'id'          => (int) $work_experience->id,
            'employee_id' => (int) $work_experience->employee_id,
            'company'     => $work_experience->company,
            'job_title'   => $work_experience->job_title,
            'from_date'   => $work_experience->from_date,
            'to_date'     => $work_experience->to_date,
            'diff_date'   => $diff,
            'comment'     => $work_experience->comment,
        ];
    }
}
