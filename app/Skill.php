<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Skill
 * @package HRis
 */
class Skill extends Model {

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'skills';

    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function employees()
    {
        return $this->belongsToMany('HRis\Employee');
    }

}
