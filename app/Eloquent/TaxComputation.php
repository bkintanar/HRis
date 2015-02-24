<?php namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TaxComputation
 * @package HRis
 */
class TaxComputation extends Model {

    /**
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
     */
    public static function getTaxRate($status, $taxableSalary)
    {
        return self::where($status, '<', $taxableSalary)
            ->orderBy($status, 'desc')
            ->first([$status, 'percentage_over', 'exemption']);
    }

}
