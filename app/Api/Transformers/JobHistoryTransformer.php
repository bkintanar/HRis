<?php

/*
 * This file is part of the HRis Software package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @version    alpha
 *
 * @author     Bertrand Kintanar <bertrand.kintanar@gmail.com>
 * @license    BSD License (3-clause)
 * @copyright  (c) 2014-2016, b8 Studios, Ltd
 *
 * @link       http://github.com/HB-Co/HRis
 */

namespace HRis\Api\Transformers;

use HRis\Api\Eloquent\JobHistory;

class JobHistoryTransformer extends BaseTransformer
{
    /**
     * Transform object into a generic array.
     *
     * @param JobHistory $job_history
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function transform(JobHistory $job_history)
    {
        return [
            'id'                   => (int) $job_history->id,
            'employee_id'          => (int) $job_history->employee_id,
            'job_title_id'         => (int) $job_history->job_title_id,
            'department_id'        => (int) $job_history->department_id,
            'employment_status_id' => (int) $job_history->employment_status_id,
            'work_shift_id'        => (int) $job_history->work_shift_id,
            'location_id'          => (int) $job_history->location_id,
            'effective_date'       => $job_history->effective_date,
            'comments'             => $job_history->comments,
        ];
    }
}
