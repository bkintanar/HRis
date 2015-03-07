<?php namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EmploymentStatus
 * @package HRis
 */
class EmploymentStatus extends Model {

    use HasPlaceholder;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
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
