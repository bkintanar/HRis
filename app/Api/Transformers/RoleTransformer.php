<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Transformers;

use Cartalyst\Sentinel\Roles\EloquentRole as Role;
use League\Fractal\TransformerAbstract;

class RoleTransformer extends TransformerAbstract
{
    /**
     * Transform object into a generic array.
     *
     * @param Role $role
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function transform(Role $role)
    {
        return [
            'id'          => (int) $role->id,
            'slug'        => $role->slug,
            'name'        => $role->name,
            'permissions' => $role->permissions,
        ];
    }
}
