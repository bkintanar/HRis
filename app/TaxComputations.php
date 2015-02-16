<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

class TaxComputations extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tax_computations';

    /**
     * @var bool
     */
    public $timestamps = false;

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
