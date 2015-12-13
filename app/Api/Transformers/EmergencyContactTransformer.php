<?php

namespace HRis\Api\Transformers;

use HRis\Api\Eloquent\EmergencyContact;
use League\Fractal\TransformerAbstract;

class EmergencyContactTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include.
     *
     * @var array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    protected $defaultIncludes = [
        'relationship'
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
            'id'              => (int)$emergency_contact->id,
            'employee_id'     => (int)$emergency_contact->employee_id,
            'first_name'      => $emergency_contact->first_name,
            'middle_name'     => $emergency_contact->middle_name,
            'last_name'       => $emergency_contact->last_name,
            'relationship_id' => (int)$emergency_contact->relationship_id,
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

        return $this->item($employee, new EmployeeTransformer);
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

        return $this->item($relationship, new RelationshipTransformer);
    }
}
