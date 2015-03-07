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
     * The attributes that are mass assignable.
     *
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
