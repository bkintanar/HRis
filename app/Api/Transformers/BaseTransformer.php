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

use League\Fractal\TransformerAbstract;

class BaseTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    private $validParams = ['order'];

    /**
     * Base Collection transformer with params.
     *
     * @param $model
     * @param $transformer
     * @param $params
     *
     * @throws \Exception
     *
     * @return \League\Fractal\Resource\Collection
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function transformCollection($model, $transformer, $params)
    {
        if ($params === null) {
            return $this->collection($model->get(), $transformer);
        }

        // Optional params validation
        $usedParams = array_keys(iterator_to_array($params));
        if (array_diff($usedParams, $this->validParams)) {
            throw new \Exception(sprintf(
                'Invalid param(s): "%s". Valid param(s): "%s"',
                implode(',', $usedParams),
                implode(',', $this->validParams)
            ));
        }

        // Processing
        list($orderCol, $orderBy) = $params->get('order');

        $model = $model
            ->orderBy($orderCol, $orderBy)
            ->get();

        return $this->collection($model, $transformer);
    }
}
