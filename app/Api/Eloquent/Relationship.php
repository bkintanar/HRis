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

/**
 * Class Relationship.
 *
 * @SWG\Definition(definition="Relationship")
 * @SWG\Property(property="id", type="integer", format="int64", default=1, description="Unique identifier for the relationship")
 * @SWG\Property(property="name", type="string", default="Father", description="Name of the relationship")
 */
class Relationship extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'relationships';
}
