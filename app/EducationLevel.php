<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EducationLevel
 * @package HRis
 */
class EducationLevel extends Model {

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'education_levels';

    /**
     * @var array
     */
    protected $fillable = ['name'];

}
