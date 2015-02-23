<?php namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PayGrade
 * @package HRis
 */
class PayGrade extends Model {

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['name', 'min_salary', 'max_salary'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pay_grades';

}
