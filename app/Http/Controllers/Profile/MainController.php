<?php

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
     */
    public function index()
    {
        return redirect()->to('profile/personal-details');
    }
}
