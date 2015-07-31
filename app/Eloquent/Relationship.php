<?php

namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Relationship
 * @package HRis\Eloquent
 */
class Relationship extends Model
{
    use HasPlaceholder;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'relationships';
}
