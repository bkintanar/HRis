<?php

namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MaritalStatus
 * @package HRis\Eloquent
 */
class MaritalStatus extends Model
{

    use HasPlaceholder;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'marital_statuses';

}
