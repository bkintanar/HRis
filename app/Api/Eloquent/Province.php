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
 * Class Province.
 *
 * @SWG\Definition(definition="Province")
 * @SWG\Property(property="id", type="integer", format="int64", default=25, description="Unique identifier for the province")
 * @SWG\Property(property="name", type="string", default="Cebu", description="Name of the province")
 */
class Province extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'provinces';
}
