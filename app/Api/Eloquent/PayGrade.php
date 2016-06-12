<?php

/*
 * This file is part of the HRis Software package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @version    alpha
 *
 * @author     Bertrand Kintanar <bertrand.kintanar@gmail.com>
 * @license    BSD License (3-clause)
 * @copyright  (c) 2014-2016, b8 Studios, Ltd
 *
 * @link       http://github.com/HB-Co/HRis
 */

namespace HRis\Api\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Swagger\Annotations as SWG;

/**
 * Class PayGrade.
 *
 * @SWG\Definition(definition="PayGrade")
 * @SWG\Property(property="id", type="integer", format="int64", default=1, description="Unique identifier for the pay grade")
 * @SWG\Property(property="name", type="string", default="Entry Level", description="Name of the pay grade")
 * @SWG\Property(property="min_salary", type="integer", format="int64", default=10000, description="Minimum salary of the pay grade")
 * @SWG\Property(property="max_salary", type="integer", format="int64", default=15000, description="Maximum salary of the pay grade")
 */
class PayGrade extends Model
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
    protected $fillable = ['name', 'min_salary', 'max_salary'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pay_grades';
}
