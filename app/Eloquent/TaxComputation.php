<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 *
 */

namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TaxComputation
 * @package HRis\Eloquent
 */
class TaxComputation extends Model
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
     * @return mixed
     * @author Jim Callanta
     */
    public static function getTaxRate($status, $taxableSalary)
    {
        return self::where($status, '<', $taxableSalary)
            ->orderBy($status, 'desc')
            ->first([$status, 'percentage_over', 'exemption']);
    }
}
