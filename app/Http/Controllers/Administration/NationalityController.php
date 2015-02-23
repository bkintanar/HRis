<?php namespace HRis\Http\Controllers\Administration;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use HRis\Eloquent\Nationality;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Administration\NationalityRequest;
use Illuminate\Support\Facades\Redirect;

/**
 * @Middleware("auth")
 */
class NationalityController extends Controller {

    /**
     * @param Sentry $auth
     * @param Nationality $nationality
     */
    public function __construct(Sentry $auth, Nationality $nationality)
    {
        parent::__construct($auth);

        $this->nationality = $nationality;
    }

    /**
     * Show the Administration - User Management
     *
     * @Get("admin/nationalities")
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->data['nationalities'] = $this->nationality->get();

        $this->data['pim'] = true;
        $this->data['pageTitle'] = 'Nationalities';

        return $this->template('pages.administration.nationality.view');
    }

    /**
     * Save the Nationality.
     *
     * @Post("admin/nationalities")
     *
     * @param NationalityRequest $request
     */
    public function store(NationalityRequest $request)
    {
        try
        {
            $this->nationality->create($request->all());

        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to add record to the database.');
        }

        return Redirect::to($request->path())->with('success', 'Record successfully added.');
    }

    /**
     * Update the Nationality.
     *
     * @Patch("admin/nationalities")
     *
     * @param NationalityRequest $request
     */
    public function update(NationalityRequest $request)
    {
        $nationality = $this->nationality->whereId($request->get('nationality_id'))->first();

        if ( ! $nationality)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to retrieve record from database.');
        }

        try
        {
            $nationality->update($request->all());
        } catch (Exception $e)
        {
            return Redirect::to($request->path())->with('danger', 'Unable to update record.');
        }

        return Redirect::to($request->path())->with('success', 'Record successfully updated.');
    }
}
