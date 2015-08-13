<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 *
 */

namespace HRis\Http\Controllers\Administration\Job;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Eloquent\PayGrade;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Administration\PayGradeRequest;

/**
 * Class PayGradeController
 * @package HRis\Http\Controllers\Administration\Job
 *
 * @Middleware("auth")
 */
class PayGradeController extends Controller
{
    /**
     * @param Sentinel $auth
     * @param PayGrade $pay_grade
     * @author Bertrand Kintanar
     */
    public function __construct(Sentinel $auth, PayGrade $pay_grade)
    {
        parent::__construct($auth);

        $this->pay_grade = $pay_grade;
    }

    /**
     * Show the Administration - Pay Grades.
     *
     * @Get("admin/job/pay-grades")
     *
     * @param PayGradeRequest $request
     * @return \Illuminate\View\View
     * @author Bertrand Kintanar
     */
    public function index(PayGradeRequest $request)
    {
        // TODO: fix me
        $pay_grades = PayGrade::all();

        $this->data['table'] = $this->setupDataTable($pay_grades);
        $this->data['pageTitle'] = 'Pay Grades';

        return $this->template('pages.administration.job.pay-grade.view');
    }

    /**
     * @param $pay_grades
     * @return array
     * @author Bertrand Kintanar
     */
    public function setupDataTable($pay_grades)
    {
        $table = [];

        $table['title'] = 'Pay Grades';
        $table['permission'] = 'admin.job.pay-grades';
        $table['headers'] = ['Id', 'Pay Grade', 'Minimum Salary', 'Maximum Salary'];
        $table['model'] = ['singular' => 'pay_grade', 'plural' => 'pay_grades', 'dashed' => 'pay-grades'];
        $table['items'] = $pay_grades;

        return $table;
    }

    /**
     * Save the Administration - Pay Grades.
     *
     * @Post("admin/job/pay-grades")
     *
     * @param PayGradeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Bertrand Kintanar
     */
    public function store(PayGradeRequest $request)
    {
        try {
            $this->pay_grade->create($request->all());
        } catch (Exception $e) {
            return redirect()->to($request->path())->with('danger', UNABLE_ADD_MESSAGE);
        }

        return redirect()->to($request->path())->with('success', SUCCESS_ADD_MESSAGE);
    }

    /**
     * Update the Administration - Pay Grades.
     *
     * @Patch("admin/job/pay-grades")
     *
     * @param PayGradeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Bertrand Kintanar
     */
    public function update(PayGradeRequest $request)
    {
        $pay_grade = $this->pay_grade->whereId($request->get('pay_grade_id'))->first();

        if (! $pay_grade) {
            return redirect()->to($request->path())->with('danger', UNABLE_RETRIEVE_MESSAGE);
        }

        try {
            $pay_grade->update($request->all());
        } catch (Exception $e) {
            return redirect()->to($request->path())->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        return redirect()->to($request->path())->with('success', SUCCESS_UPDATE_MESSAGE);
    }
}
