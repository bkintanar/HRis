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
 * Class Skill.
 *
 * @SWG\Definition(definition="Skill")
 * @SWG\Property(property="id", type="integer", format="int64", default=1, description="Unique identifier for the skill")
 * @SWG\Property(property="name", type="string", default="PHP", description="Name of the skill")
 */
class Skill extends Model
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
    protected $table = 'skills';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function employees()
    {
        return $this->belongsToMany('HRis\Api\Eloquent\Employee');
    }
}
