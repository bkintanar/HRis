<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SSSContributions
 * @package HRis
 */
class SSSContribution extends Model {

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sss_contributions';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getSalarySSS($salary)
    {
        return self::where('range_compensation_from', '<=', $salary)
            ->orderBy('range_compensation_from', 'desc')
            ->first();
    }

}
