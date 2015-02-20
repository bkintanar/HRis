<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Nationality
 * @package HRis
 */
class Nationality extends Model {

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'nationalities';

    /**
     * @var array
     */
    protected $fillable = ['name'];

}
