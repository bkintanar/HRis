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
 * Class Location.
 *
 * @SWG\Definition(definition="Location")
 * @SWG\Property(property="id", type="integer", format="int64", default=1, description="Unique identifier for the location")
 * @SWG\Property(property="name", type="string", default="Unit 203", description="Name of the location")
 */
class Location extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
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
