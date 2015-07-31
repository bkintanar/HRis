<?php

namespace HRis\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Education
 * @package HRis\Eloquent
 */
class Education extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Additional fields to treat as Carbon instances.
     *
     * @var array
     */
    protected $dates = ['from_date', 'to_date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'education_level_id',
        'institute',
        'major_specialization',
        'from_date',
        'to_date',
        'gpa_score'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'educations';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo('HRis\Eloquent\Employee', 'id', 'employee_id');
    }

    /**
     * @param $from_date
     */
    public function setFromDateAttribute($from_date)
    {
        $this->attributes['from_date'] = Carbon::parse($from_date) ? : null;
    }

    /**
     * @param $to_date
     */
    public function setToDateAttribute($to_date)
    {
        $this->attributes['to_date'] = Carbon::parse($to_date) ? : null;
    }
}
