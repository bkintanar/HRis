<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Controllers;

use HRis\Api\Eloquent\Employee;
use HRis\Api\ThirdParty\Elastic;
use Illuminate\Http\Request;

class PlaygroundController extends BaseController
{
    protected $employee;

    protected $elastic;

    public function __construct(Employee $employee, Elastic $elastic)
    {
        $this->employee = $employee;
        $this->elastic = $elastic;
    }

    public function index(Request $request)
    {
        $result = $this->elastic->searchEmployee($request->all());

        return $this->responseAPI(201, SUCCESS_RETRIEVE_MESSAGE, compact('result'));
    }
}
