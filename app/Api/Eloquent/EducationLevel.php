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
 * Class EducationLevel.
 *
 * @SWG\Definition(definition="EducationLevel")
 * @SWG\Property(property="id", type="integer", format="int64", default=1, description="Unique identifier for the education level")
 * @SWG\Property(property="name", type="string", default="Administration", description="Name of the education level")
 */
class EducationLevel extends Model
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
    protected $fillable = ['name'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'education_levels';
}
