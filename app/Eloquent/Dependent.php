<?php namespace HRis\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Dependent
 * @package HRis
 */
class Dependent extends Model {

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Additional fields to treat as Carbon instances.
     *
     * @var array
     */
    protected $dates = ['birth_date'];

    /**
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'first_name',
        'middle_name',
        'last_name',
        'relationship_id',
        'birth_date'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dependents';

    /**
     * @param $value
     */
    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = Carbon::parse($value) ? : null;
    }

}
