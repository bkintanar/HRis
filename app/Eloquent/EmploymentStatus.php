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
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'employment_statuses';

    /**
     * @var array
     */
    protected $fillable = ['name', 'class'];

}
