<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MaritalStatus.
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
