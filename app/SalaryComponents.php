<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SalaryComponents
 * @package HRis
 */
class SalaryComponents extends Model {

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
        $salaryComponents = self::where('name', 'LIKE', '%Basic%')
            ->orWhere('name', 'LIKE', '%SSS%')
            ->orderBy('id', 'asc')
            ->get(['id'])
            ->take(2);

        return ['monthlyBasic' => $salaryComponents->first()->id, 'SSS' => $salaryComponents->last()->id];
        
    }

}
