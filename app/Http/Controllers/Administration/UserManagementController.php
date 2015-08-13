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
use HRis\Eloquent\User;
use HRis\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

/**
 * Class UserManagementController
 * @package HRis\Http\Controllers\Administration
 *
 * @Middleware("auth")
 */
class UserManagementController extends Controller
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @param Sentinel $auth
     * @param User $user
     * @author Bertrand Kintanar
     */
    public function __construct(Sentinel $auth, User $user)
    {
        parent::__construct($auth);

        $this->user = $user;
    }

    /**
     * Show the Administration - User Management
     *
     * @Get("admin/user-management")
     *
     * @return \Illuminate\View\View
     * @author Bertrand Kintanar
     */
    public function index()
    {
        $this->data['users'] = $this->user->with('employee')->get();

        $this->data['pim'] = true;
        $this->data['pageTitle'] = 'User Management';

        return $this->template('pages.administration.user-management.view');
    }


    /**
     * Show the Administration - User with the given Id.
     *
     * @Get("admin/user-management/{id}")
     *
     * @author Bertrand Kintanar
     */
    public function viewUser()
    {
        // TODO: Check if {id} exist
        return redirect()->to(Request::path() . '/details');
    }

    /**
     * @Get("admin/user-management/{id}/details")
     *
     * @param $user_id
     * @return \Illuminate\View\View
     * @author Bertrand Kintanar
     */
    public function userDetails($user_id)
    {
        if ($user_id) {
            $user = $this->user->whereId($user_id)->first();
        }

        $this->data['user'] = $user;

        $this->data['disabled'] = 'disabled';
        $this->data['pageTitle'] = 'User Details';

        return $this->template('pages.administration.user-management.user.view');
    }

    /**
     * @Get("admin/user-management/{id}/permissions")
     *
     * @param $user_id
     * @return \Illuminate\View\View
     * @author Bertrand Kintanar
     */
    public function userPermissions($user_id)
    {
        if ($user_id) {
            $user = $this->user->whereId($user_id)->first();
        }

        $this->data['user'] = $user;

        $this->data['disabled'] = 'disabled';
        $this->data['pageTitle'] = 'User Details';

        return $this->template('pages.administration.user-management.permissions.view');
    }
}
