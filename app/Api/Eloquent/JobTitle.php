<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Swagger\Annotations as SWG;

/**
 * Class JobTitle.
 *
 * @SWG\Definition(definition="JobTitle")
 * @SWG\Property(property="id", type="integer", format="int64", default=1, description="Unique identifier for the job title")
 * @SWG\Property(property="name", type="string", default="Chief Executive Officer", description="Name of the job title")
 * @SWG\Property(property="description", type="string", default="CEO of the company", description="Description of the job title")
 */
class JobTitle extends Model
{
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
