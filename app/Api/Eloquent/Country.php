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
 * Class Country.
 *
 * @SWG\Definition(definition="Country")
 * @SWG\Property(property="id", type="integer", format="int64", default=1, description="Unique identifier for the country")
 * @SWG\Property(property="name", type="string", default="Afghanistan", description="Name of the country")
 */
class Country extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'countries';
}
