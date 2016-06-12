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

use HRis\Api\Eloquent\JobTitle;

class JobTitleTransformer extends BaseTransformer
{
    /**
     * Transform object into a generic array.
     *
     * @param JobTitle $job_title
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function transform(JobTitle $job_title)
    {
        return [
            'id'          => (int) $job_title->id,
            'name'        => $job_title->name,
            'description' => $job_title->description,
        ];
    }
}
