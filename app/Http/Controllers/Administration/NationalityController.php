<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 *
 */

namespace HRis\Http\Controllers\Administration;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use HRis\Eloquent\Nationality;
use HRis\Http\Controllers\Controller;
use HRis\Http\Requests\Administration\NationalityRequest;

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
     * @author Bertrand Kintanar
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
     * @author Bertrand Kintanar
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
     * @return \Illuminate\Http\RedirectResponse
     * @author Bertrand Kintanar
     */
    public function store(NationalityRequest $request)
    {
        try {
            $this->nationality->create($request->all());
        } catch (Exception $e) {
            return redirect()->to($request->path())->with('danger', UNABLE_ADD_MESSAGE);
        }

        return redirect()->to($request->path())->with('success', SUCCESS_ADD_MESSAGE);
    }

    /**
     * Update the Nationality.
     *
     * @Patch("admin/nationalities")
     *
     * @param NationalityRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Bertrand Kintanar
     */
    public function update(NationalityRequest $request)
    {
        $nationality = $this->nationality->whereId($request->get('nationality_id'))->first();

        if (! $nationality) {
            return redirect()->to($request->path())->with('danger', UNABLE_RETRIEVE_MESSAGE);
        }

        try {
            $nationality->update($request->all());
        } catch (Exception $e) {
            return redirect()->to($request->path())->with('danger', UNABLE_UPDATE_MESSAGE);
        }

        return redirect()->to($request->path())->with('success', SUCCESS_UPDATE_MESSAGE);
    }
}
