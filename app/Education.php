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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo('HRis\Employee', 'id', 'employee_id');
    }

}
