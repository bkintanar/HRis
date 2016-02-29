<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Transformers;

use HRis\Api\Eloquent\Country;

class CountryTransformer extends BaseTransformer
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
            'id'          => (int) $country->id,
            'name'        => $country->name,
        ];
    }
}
