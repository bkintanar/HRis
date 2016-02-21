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

/**
 * Class CustomFieldValue.
 */
class CustomFieldValue extends Model
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
    protected $fillable = ['custom_field_id', 'value', 'employee_id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'custom_field_values';

    /**
     * An education object belongs to on employee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function employee()
    {
        return $this->belongsTo('HRis\Api\Eloquent\Employee', 'employee_id', 'id');
    }

    /**
     * A custom field value object belongs to on a custom field.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function customField()
    {
        return $this->belongsTo('HRis\Api\Eloquent\CustomField', 'custom_field_id', 'id');
    }
}
