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
 * Class MaritalStatus.
 *
 * @SWG\Definition(definition="MaritalStatus")
 * @SWG\Property(property="id", type="integer", format="int64", default=1, description="Unique identifier for the marital status")
 * @SWG\Property(property="name", type="string", default="Single", description="Name of the marital status")
 */
class MaritalStatus extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'marital_statuses';
}
