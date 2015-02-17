<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

/**
 * Class JobTitle
 * @package HRis
 */
class JobTitle extends Model {

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'job_titles';

    /**
     * @var array
     */
    protected $fillable = ['name', 'description'];

}
