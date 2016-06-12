<?php

/*
 * This file is part of the HRis Software package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @version    alpha
 *
 * @author     Bertrand Kintanar <bertrand.kintanar@gmail.com>
 * @license    BSD License (3-clause)
 * @copyright  (c) 2014-2016, b8 Studios, Ltd
 *
 * @link       http://github.com/HB-Co/HRis
 */

namespace HRis\Api\Transformers;

use HRis\Api\Eloquent\User;
use League\Fractal\ParamBag;

class UserTransformer extends BaseTransformer
{
    /**
     * Resources that can be included if requested.
     *
     * @var array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    protected $availableIncludes = [
        'employee',
        'role',
    ];

    /**
     * Transform object into a generic array.
     *
     * @param User $user
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function transform(User $user)
    {
        return [
            'id'         => (int) $user->id,
            'email'      => $user->email,
            'last_login' => $user->last_login,
        ];
    }

    /**
     * Include Employee.
     *
     * @param User $user
     *
     * @return \League\Fractal\Resource\Item
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeEmployee(User $user)
    {
        $employee = $user->employee;

        return $this->item($employee, new EmployeeTransformer());
    }

    /**
     * Include Role.
     *
     * @param User     $user
     * @param ParamBag $params
     *
     * @throws \Exception
     *
     * @return \League\Fractal\Resource\Collection
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeRole(User $user, ParamBag $params = null)
    {
        $roles = $user->roles();

        return $this->transformCollection($roles, new RoleTransformer(), $params);
    }
}
