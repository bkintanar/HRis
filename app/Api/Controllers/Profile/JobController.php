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

namespace HRis\Api\Controllers\Profile;

use Exception;
use HRis\Api\Requests\Profile\JobRequest;
use Irradiate\Api\Controllers\BaseController;
use Irradiate\Eloquent\Employee;
use Irradiate\Eloquent\JobHistory;

class JobController extends BaseController
{
    /**
     * @var Employee
     */
    private $employee;

    /**
     * @var JobHistory
     */
    private $job_history;

    /**
     * @param Employee   $employee
     * @param JobHistory $job_history
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function __construct(Employee $employee, JobHistory $job_history)
    {
        $this->employee = $employee;
        $this->job_history = $job_history;
    }

    /**
     * Update the Profile - Job.
     *
     * @param JobRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function update(JobRequest $request)
    {
        $_employee = $request->get('employee');

        $employee_id = $_employee['id'];

        $employee = $this->employee->whereId($employee_id)->first();

        $job_history = [];

        try {
            $_job_history = array_slice($_employee['job_history']['data'], 0, 9);

            unset($_job_history['id'], $_job_history['work_shift_id']);

            $_job_history['effective_date'] = $_job_history['effective_date'] != '' ? $_job_history['effective_date'] : null;
            $_job_history['comments'] = $_job_history['comments'] != '' ? $_job_history['comments'] : null;

            $job_history_fillables = $this->job_history->getFillable();
            $current_employee_job = $this->job_history->getCurrentEmployeeJob($job_history_fillables, $employee_id);

            if ($current_employee_job != $_job_history) {
                $job_history = $this->job_history->create(array_filter($_job_history));
            }

            $attributes = array_filter(array_slice($_employee, 28, 3));

            $employee->update($attributes);
        } catch (Exception $e) {
            return $this->responseAPI(422, UNABLE_UPDATE_MESSAGE);
        }

        return $this->responseAPI(200, SUCCESS_UPDATE_MESSAGE, compact('job_history'));
    }

    /**
     * Delete the Profile - Job.
     *
     * @param JobHistory $job_history
     * @param JobRequest $request
     *
     * @return \Dingo\Api\Http\Response
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function destroy(JobHistory $job_history, JobRequest $request)
    {
        return $this->destroyModel($job_history, $this->job_history);
    }
}
