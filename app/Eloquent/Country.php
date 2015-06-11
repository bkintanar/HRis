<?php

namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 * @package HRis\Eloquent
 */
class Country extends Model
{

    use HasPlaceholder;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'countries';

}
