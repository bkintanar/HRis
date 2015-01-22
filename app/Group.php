<?php namespace HRis;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'groups';

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany('HRis\Group', 'users_groups', 'group_id', 'user_id');
    }

}
