<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Education
 * @package HRis
 */
class Education extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'educations';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
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
     * @param $value
     */
    public function setFromDateAttribute($value)
    {
        $this->attributes['from_date'] = $value ?: null;
    }

    /**
     * @param $value
     */
    public function setToDateAttribute($value)
    {
        $this->attributes['to_date'] = $value ?: null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo('HRis\Employee', 'id', 'employee_id');
    }

}
