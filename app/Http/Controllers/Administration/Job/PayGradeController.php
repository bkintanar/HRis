<?php namespace HRis\Http\Controllers\Administration\Job;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Administration\PayGradeRequest;
use HRis\PayGrade;
use Illuminate\Support\Facades\Redirect;

/**
 * @Middleware("auth")
 */
class PayGradeController extends Controller {

    public function __construct(Sentry $auth, PayGrade $pay_grade)
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
     */
    public function index(PayGradeRequest $request)
    {
        // TODO: fix me
        $this->data['payGrades'] = PayGrade::all();

        $this->data['pageTitle'] = 'Pay Grades';

        return $this->template('pages.administration.job.pay-grade.view');
    }

    /**
     * Save the Administration - Pay Grades.
     *
     * @Post("admin/job/pay-grades")
     *
     * @param PayGradeRequest $request
     */
    public function store(PayGradeRequest $request)
    {
        try
        {
            $this->pay_grade->create($request->all());

        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to add record to the database.');
        }

        return Redirect::to($request->path())->with('success', 'Record successfully added.');
    }

    /**
     * Update the Administration - Pay Grades.
     *
     * @Patch("admin/job/pay-grades")
     *
     * @param PayGradeRequest $request
     */
    public function update(PayGradeRequest $request)
    {
        $pay_grade = $this->pay_grade->whereId($request->get('pay_grade_id'))->first();

        if ( ! $pay_grade)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to retrieve record from database.');
        }

        try
        {
            $pay_grade->update($request->all());

        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to update record.');
        }

        return Redirect::to($request->path())->with('success', 'Record successfully updated.');
    }
}
