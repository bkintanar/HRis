<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Transformers;

use HRis\Api\Eloquent\City;

class CityTransformer extends BaseTransformer
{
    /**
     * Resources that can be included if requested.
     *
     * @var array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    protected $availableIncludes = [
        'province',
    ];

    /**
     * Transform object into a generic array.
     *
     * @param City $city
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function transform(City $city)
    {
        return [
            'id'          => (int) $city->id,
            'province_id' => (int) $city->province_id,
            'name'        => $city->name,
        ];
    }

    /**
     * Include Province.
     *
     * @param City $city
     *
     * @return \League\Fractal\Resource\Item
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeProvince(City $city)
    {
        $province = $city->province;

        return $this->item($province, new ProvinceTransformer());
    }
}
