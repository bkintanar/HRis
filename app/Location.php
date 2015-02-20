<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Location
 * @package HRis
 */
class Location extends Model {

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'locations';

} 