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
 * Class Nationality.
 *
 * @SWG\Definition(definition="Nationality")
 * @SWG\Property(property="id", type="integer", format="int64", default=1, description="Unique identifier for the nationality")
 * @SWG\Property(property="name", type="string", default="Afghan", description="Name of the nationality")
 */
class Nationality extends Model
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
    protected $table = 'nationalities';
}
