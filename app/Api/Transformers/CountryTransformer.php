<?php

namespace HRis\Api\Transformers;

use HRis\Api\Eloquent\Country;
use League\Fractal\TransformerAbstract;

class CountryTransformer extends TransformerAbstract
{
    /**
     * Transform object into a generic array.
     *
     * @param Country $country
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function transform(Country $country)
    {
        return [
            'id'          => (int)$country->id,
            'name'        => $country->name
        ];
    }
}
