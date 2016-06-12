<?php

/*
 * This file is part of the HRis Software package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @version    alpha
 *
 * @author     Bertrand Kintanar <bertrand.kintanar@gmail.com>
 * @license    BSD License (3-clause)
 * @copyright  (c) 2014-2016, b8 Studios, Ltd
 *
 * @link       http://github.com/HB-Co/HRis
 */
 
namespace HRis\Api\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Timelog extends Model
{
    protected $fillable = [
        'type_id',
        'holiday_id',
        'employee_id',
        'schedule_id',
        'in',
        'out',
        'rendered_hours',
    ];

    protected $dates = ['in', 'out'];

    /**
     * Automatically update rendered hours everytime "in" field is occupied or changed.
     *
     * @param $in
     *
     * @author Harlequin Doyon <harlequin.doyon@gmail.com>
     */
    public function setInAttribute($in)
    {
        $this->attributes['in'] = (new Carbon($in))->format('Y-m-d H:i');

        if (!empty($this->attributes['in']) && !empty($this->attributes['out'])) {
            $out = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['out']);

            $this->attributes['rendered_hours'] = $this->setRenderedHours($in, $out);
        }
    }

    /**
     * Returns the rendered hours after calculation of the diff.
     *
     * @param Carbon $in
     * @param Carbon $out
     *
     * @return string
     *
     * @author Bertrand Kintanar <bertrand.kintanar@gmail.com>
     */
    public function setRenderedHours(Carbon $in, Carbon $out)
    {
        $diff = $in->diff($out);

        $d = $diff->d ?: 0;
        $h = $diff->h + ($d * 24);
        $i = $diff->i / 60;

        return number_format(($h + $i), 2);
    }

    /**
     * Automatically update rendered hours everytime "out" field is occupied or changed.
     *
     * @param $out
     *
     * @author Harlequin Doyon <harlequin.doyon@gmail.com>
     */
    public function setOutAttribute($out)
    {
        $this->attributes['out'] = (new Carbon($out))->format('Y-m-d H:i');

        if (!empty($this->attributes['in']) && !empty($this->attributes['out'])) {
            $in = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['in']);

            $this->attributes['rendered_hours'] = $this->setRenderedHours($in, $out);
        }
    }
}
