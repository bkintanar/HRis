<?php namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SalaryComponents
 * @package HRis
 */
class SalaryComponent extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'salary_components';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return array
     */
    function getSalaryAndSSS()
    {
        $salaryComponent = self::where('name', 'LIKE', '%Basic%')
            ->orWhere('name', 'LIKE', '%SSS%')
            ->orderBy('id', 'asc')
            ->get(['id'])
            ->take(2);

        return ['monthlyBasic' => $salaryComponent->first()->id, 'SSS' => $salaryComponent->last()->id];

    }

}
