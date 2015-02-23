<?php namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EmploymentStatus
 * @package HRis
 */
class EmploymentStatus extends Model {

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = ['name', 'class'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'employment_statuses';

}
