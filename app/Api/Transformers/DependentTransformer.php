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

use HRis\Api\Eloquent\Dependent;

class DependentTransformer extends BaseTransformer
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
     * @param Dependent $dependent
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function transform(Dependent $dependent)
    {
        return [
            'id'              => (int) $dependent->id,
            'employee_id'     => (int) $dependent->employee_id,
            'first_name'      => $dependent->first_name,
            'middle_name'     => $dependent->middle_name,
            'last_name'       => $dependent->last_name,
            'relationship_id' => (int) $dependent->relationship_id,
            'birth_date'      => $dependent->birth_date,
        ];
    }

    /**
     * Include Employee.
     *
     * @param Dependent $dependent
     *
     * @return \League\Fractal\Resource\Item
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeEmployee(Dependent $dependent)
    {
        $employee = $dependent->employee;

        return $this->item($employee, new EmployeeTransformer());
    }

    /**
     * Include Relationship.
     *
     * @param Dependent $dependent
     *
     * @return \League\Fractal\Resource\Item
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeRelationship(Dependent $dependent)
    {
        $relationship = $dependent->relationship;

        return $this->item($relationship, new RelationshipTransformer());
    }
}
