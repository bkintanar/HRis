<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Eloquent;

use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * Class User.
 */
class User extends SentinelUser implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @throws Exception
     *
     * @return mixed
     *
     * @author Bertrand Kintanar
     */
    public function role()
    {
        $roles = $this->getRoles();

        if (empty($roles)) {
            throw new Exception('User not in group.');
        }

        return $roles[0];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     *
     * @author Bertrand Kintanar
     */
    public function employee()
    {
        return $this->hasOne('HRis\Eloquent\Employee');
    }
}
