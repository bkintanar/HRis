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

use HRis\Api\Eloquent\Province;

class ProvinceTransformer extends BaseTransformer
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
            'id'   => (int) $province->id,
            'name' => $province->name,
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
