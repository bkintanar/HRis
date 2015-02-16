<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

class SalaryComponents extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'salary_components';

    public $timestamps = false;

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
