<?php namespace HRis\Http\Controllers\Profile;

use HRis\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

/**
 * @Middleware("auth")
 */
class MainController extends Controller {

    /**
     * @Get("profile")
     */
    public function index()
    {
        return Redirect::to('profile/personal-details');
    }
}
