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

use HRis\Api\Eloquent\CustomFieldSection;
use League\Fractal\ParamBag;

class CustomFieldSectionTransformer extends BaseTransformer
{
    /**
     * List of resources to automatically include.
     *
     * @var array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    protected $defaultIncludes = ['custom_fields'];

    /**
     * Transform object into a generic array.
     *
     * @param CustomFieldSection $custom_field_section
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function transform(CustomFieldSection $custom_field_section)
    {
        return [
            'id'        => (int) $custom_field_section->id,
            'name'      => $custom_field_section->name,
            'screen_id' => (int) $custom_field_section->screen_id,
        ];
    }

    /**
     * Include CustomFields.
     *
     * @param CustomFieldSection $custom_field_section
     * @param ParamBag           $params
     *
     * @throws \Exception
     *
     * @return \League\Fractal\Resource\Collection
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function includeCustomFields(CustomFieldSection $custom_field_section, ParamBag $params = null)
    {
        $custom_fields = $custom_field_section->customFields();

        return $this->transformCollection($custom_fields, new CustomFieldTransformer(), $params);
    }
}
