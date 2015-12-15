<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Transformers;

use HRis\Api\Eloquent\Province;
use League\Fractal\TransformerAbstract;

class ProvinceTransformer extends TransformerAbstract
{
    /**
     * Resources that can be included if requested.
     *
     * @var array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    protected $availableIncludes = [
        'country',
    ];

    /**
     * Transform object into a generic array.
     *
     * @param Province $province
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function transform(Province $province)
    {
        return [
            'id'          => (int) $province->id,
            'name'        => $province->name,
        ];
    }

    /**
     * Include Country.
     *
     * @param Province $province
     *
     * @return \League\Fractal\Resource\Item
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeCountry(Province $province)
    {
        $country = $province->country;

        return $this->item($country, new CountryTransformer());
    }
}
