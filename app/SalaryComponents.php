<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SalaryComponents
 * @package HRis
 */
class SalaryComponents extends Model {

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'salary_components';

    /**
     * @return array
     */
    function getSalaryAndSSS()
    {
        $salaryComponents = self::where('components', 'LIKE', '%Basic%')
            ->orWhere('components', 'LIKE', '%SSS%')
            ->orderBy('id', 'asc')
            ->get(['id'])
            ->take(2);

        return ['monthlyBasic' => $salaryComponents->first()->id, 'SSS' => $salaryComponents->last()->id];
    }

}
