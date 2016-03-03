<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
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
