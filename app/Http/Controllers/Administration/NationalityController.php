<?php

namespace HRis\Http\Controllers\Administration;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Eloquent\Nationality;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Administration\NationalityRequest;
use Illuminate\Support\Facades\Redirect;

/**
 * Class NationalityController
 * @package HRis\Http\Controllers\Administration
 *
 * @Middleware("auth")
 */
class NationalityController extends Controller
{

    /**
     * @param Sentinel $auth
     * @param Nationality $nationality
     */
    public function __construct(Sentinel $auth, Nationality $nationality)
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
        try {
            $this->nationality->create($request->all());

        } catch (Exception $e) {
            return Redirect::to($request->path())->with('danger', UNABLE_ADD_MESSAGE);
        }

        return Redirect::to($request->path())->with('success', SUCCESS_ADD_MESSAGE);
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

        if ( ! $nationality) {
            return Redirect::to($request->path())->with('danger', UNABLE_RETRIEVE_MESSAGE);
        }

        try {
            $nationality->update($request->all());
        } catch (Exception $e) {
            return Redirect::to($request->path())->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        return Redirect::to($request->path())->with('success', SUCCESS_UPDATE_MESSAGE);
    }
}
