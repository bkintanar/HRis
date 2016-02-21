<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link http://github.com/HB-Co/HRis
 */
namespace HRis\Api\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Swagger\Annotations as SWG;

/**
 * Class EmploymentStatus.
 *
 * @SWG\Definition(definition="EmploymentStatus")
 * @SWG\Property(property="id", type="integer", format="int64", default=2, description="Unique identifier for the employment status")
 * @SWG\Property(property="name", type="string", default="Regular", description="Name of the employment status")
 * @SWG\Property(property="class", type="string", default="label-success", description="Bootstrap class for label of the employment status")
 */
class EmploymentStatus extends Model
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
    protected $fillable = ['name', 'class'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'employment_statuses';
}
