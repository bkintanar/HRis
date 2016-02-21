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
 * Class CustomFieldType.
 *
 * @SWG\Definition(definition="CustomFieldType", required={"id", "employee_id"})
 * @SWG\Property(property="id", type="integer", format="int64", default=1, description="Unique identifier for the custom field type")
 * @SWG\Property(property="name", type="string", default="Text", description="name of the custom field type")
 */
class CustomFieldType extends Model
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
    protected $table = 'custom_field_types';
}
