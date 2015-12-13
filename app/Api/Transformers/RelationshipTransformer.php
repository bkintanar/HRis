<?php

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
            'id'   => (int)$relationship->id,
            'name' => $relationship->name
        ];
    }
}
