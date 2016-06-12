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
 
namespace HRis\Api\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TaxComputation.
 */
class TaxComputations extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tax_computations';

    /**
     * @param $status
     * @param $taxableSalary
     *
     * @return mixed
     *
     * @author Jim Callanta
     */
    public static function getTaxRate($status, $taxableSalary)
    {
        return self::where($status, '<', $taxableSalary)
            ->orderBy($status, 'desc')
            ->first([$status, 'percentage_over', 'exemption']);
    }
}
