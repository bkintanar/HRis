<?php namespace HRis\Http\Controllers\Administration;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use HRis\Http\Controllers\Controller;
use HRis\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

/**
 * @Middleware("auth")
 */
class UserManagementController extends Controller {

    protected $user;

    public function __construct(Sentry $auth, User $user)
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
     */
    public function viewUser()
    {
        // TODO: Check if {id} exist
        return Redirect::to(Request::path() . '/details');
    }

    /**
     *
     * @Get("admin/user-management/{id}/details")
     */
    public function userDetails($user_id)
    {
        if ($user_id)
        {
            $user = $this->user->whereId($user_id)->first();
        }

        $this->data['user'] = $user;

        $this->data['disabled'] = 'disabled';
        $this->data['pageTitle'] = 'User Details';

        return $this->template('pages.administration.user-management.user.view');
    }

    /**
     *
     * @Get("admin/user-management/{id}/permissions")
     */
    public function userPermissions($user_id)
    {
        if ($user_id)
        {
            $user = $this->user->whereId($user_id)->first();
        }

        $this->data['user'] = $user;

        $this->data['disabled'] = 'disabled';
        $this->data['pageTitle'] = 'User Details';

        return $this->template('pages.administration.user-management.permissions.view');
    }
}
