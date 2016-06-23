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
