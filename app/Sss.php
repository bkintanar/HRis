<?php

namespace HRis;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SSSContributions.
 */
class Sss extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sss_contribution';
}
