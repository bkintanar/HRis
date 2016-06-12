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

use HRis\Api\Eloquent\EmergencyContact;

class EmergencyContactTransformer extends BaseTransformer
{
    /**
     * List of resources to automatically include.
     *
     * @var array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    protected $defaultIncludes = [
        'relationship',
    ];

    /**
     * Resources that can be included if requested.
     *
     * @var array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    protected $availableIncludes = [
        'employee',
    ];

    /**
     * Transform object into a generic array.
     *
     * @param EmergencyContact $emergency_contact
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function transform(EmergencyContact $emergency_contact)
    {
        return [
            'id'              => (int) $emergency_contact->id,
            'employee_id'     => (int) $emergency_contact->employee_id,
            'first_name'      => $emergency_contact->first_name,
            'middle_name'     => $emergency_contact->middle_name,
            'last_name'       => $emergency_contact->last_name,
            'relationship_id' => (int) $emergency_contact->relationship_id,
            'home_phone'      => $emergency_contact->home_phone,
            'mobile_phone'    => $emergency_contact->mobile_phone,
        ];
    }

    /**
     * Include Employee.
     *
     * @param EmergencyContact $emergency_contact
     *
     * @return \League\Fractal\Resource\Item
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeEmployee(EmergencyContact $emergency_contact)
    {
        $employee = $emergency_contact->employee;

        return $this->item($employee, new EmployeeTransformer());
    }

    /**
     * Include Relationship.
     *
     * @param EmergencyContact $emergency_contact
     *
     * @return \League\Fractal\Resource\Item
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeRelationship(EmergencyContact $emergency_contact)
    {
        $relationship = $emergency_contact->relationship;

        return $this->item($relationship, new RelationshipTransformer());
    }
}
