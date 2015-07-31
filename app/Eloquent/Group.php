<?php

namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Group
 * @package HRis\Eloquent
 */
class Group extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'groups';

    public function users()
    {
        return $this->belongsToMany('HRis\Eloquent\Group', 'users_groups', 'group_id', 'user_id');
    }
}
