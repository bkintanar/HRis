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
 * Class Department.
 *
 * @SWG\Definition(definition="Department")
 * @SWG\Property(property="id", type="integer", format="int64", default=1, description="Unique identifier for the department")
 * @SWG\Property(property="name", type="string", default="Administration", description="Name of the department")
 */
class Department extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'departments';
}
