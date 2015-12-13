<?php

namespace HRis\Api\Transformers;

use HRis\Api\Eloquent\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
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
     * @param Role $user
     *
     * @return \League\Fractal\Resource\Collection
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeRole(User $user)
    {
        $roles = $user->roles;

        return $this->collection($roles, new RoleTransformer());
    }
}
