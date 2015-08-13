<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 *
 */

namespace HRis\Http\Controllers\Profile;

use HRis\Http\Controllers\Controller;

/**
 * Class MainController
 * @package HRis\Http\Controllers\Profile
 *
 * @Middleware("auth")
 */
class MainController extends Controller
{
    /**
     * @Get("profile")
     *
     * @author Bertrand Kintanar
     */
    public function index()
    {
        return redirect()->to('profile/personal-details');
    }
}
