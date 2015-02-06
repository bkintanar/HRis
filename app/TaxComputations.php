<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

class TaxComputations extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tax_computations';

    public $timestamps = false;

    public function getTaxRate($status, $taxableSalary)
    {
        return self::where($status, '<', $taxableSalary)
            ->orderBy($status, 'desc')
            ->first([$status, 'percentage_over', 'exemption']);
    }

}
