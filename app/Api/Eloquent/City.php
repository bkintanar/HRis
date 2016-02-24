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
 * Class City.
 *
 * @SWG\Definition(definition="City")
 * @SWG\Property(property="id", type="integer", format="int64", default=457, description="Unique identifier for the city")
 * @SWG\Property(property="name", type="string", default="Bogo City", description="Name of the city")
 */
class City extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cities';

    /**
     * A city object belongs to on province.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
