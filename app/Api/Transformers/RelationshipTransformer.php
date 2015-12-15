<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Transformers;

use HRis\Api\Eloquent\Relationship;
use League\Fractal\TransformerAbstract;

class RelationshipTransformer extends TransformerAbstract
{
    /**
     * Transform object into a generic array.
     *
     * @param Relationship $relationship
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function transform(Relationship $relationship)
    {
        return [
            'id'   => (int) $relationship->id,
            'name' => $relationship->name,
        ];
    }
}
