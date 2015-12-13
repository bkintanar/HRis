<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Api\Controllers;

use HRis\Api\Eloquent\Employee;
use HRis\Api\Requests\EmployeeRequest;
use HRis\Api\Transformers\EmployeeTransformer;

class EmployeeController extends BaseController
{
    /**
     * @param Employee $employee
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function __construct(Employee $employee)
    {
        $this->middleware('jwt.auth');

        $this->employee = $employee;
    }

    /**
     * @param EmployeeRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function getByEmployeeId(EmployeeRequest $request)
    {
        $employee = $this->employee->getEmployeeById($request->get('employee_id'), null);

        return $this->item($employee, new EmployeeTransformer);
    }
}
