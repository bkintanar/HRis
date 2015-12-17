<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Controllers\Profile;

use Dingo\Api\Facade\API;
use Exception;
use HRis\Api\Controllers\BaseController;
use HRis\Api\Eloquent\Dependent;
use HRis\Api\Eloquent\Employee;
use HRis\Api\Requests\Profile\DependentsRequest;

class DependentsController extends BaseController
{
    /**
     * @var Employee
     */
    protected $employee;

    /**
     * @var Dependent
     */
    protected $dependent;

    /**
     * @param Employee  $employee
     * @param Dependent $dependent
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function __construct(Employee $employee, Dependent $dependent)
    {
        $this->middleware('jwt.auth');

        $this->employee = $employee;
        $this->dependent = $dependent;
    }

    /**
     * Save the Profile - Dependents.
     *
     * @param DependentsRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function store(DependentsRequest $request)
    {
        try {
            $dependent = $this->dependent->create($request->all());
        } catch (Exception $e) {
            return API::response()->array(['status' => UNABLE_ADD_MESSAGE])->statusCode(500);
        }

        return API::response()->array(['dependent' => $dependent, 'status' => SUCCESS_ADD_MESSAGE])->statusCode(200);
    }

    /**
     * Update the Profile - Dependents.
     *
     * @param DependentsRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function update(DependentsRequest $request)
    {
        $dependent = $this->dependent->whereId($request->get('dependent_id'))->first();

        if (!$dependent) {
            return redirect()->to($request->path())->with('danger', UNABLE_RETRIEVE_MESSAGE);
        }

        try {
            $dependent->update($request->all());
        } catch (Exception $e) {
            return API::response()->array(['status' => UNABLE_UPDATE_MESSAGE])->statusCode(500);
        }

        return API::response()->array(['status' => SUCCESS_UPDATE_MESSAGE])->statusCode(200);
    }

    /**
     * Delete the Profile - Dependents.
     *
     * @param DependentsRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function destroy(DependentsRequest $request)
    {
        $dependent_id = $request->get('id');

        try {
            $this->dependent->whereId($dependent_id)->delete();
        } catch (Exception $e) {
            return API::response()->array(['status' => UNABLE_DELETE_MESSAGE])->statusCode(500);
        }

        return API::response()->array(['status' => SUCCESS_DELETE_MESSAGE])->statusCode(200);
    }
}
