<?php

namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 * @package HRis\Eloquent
 */
class Department extends Model
{

    use HasPlaceholder;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'departments';

}
