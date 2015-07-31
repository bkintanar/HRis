<?php

namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class JobTitle
 * @package HRis\Eloquent
 */
class JobTitle extends Model
{
    use HasPlaceholder;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'job_titles';
}
