<?php

/**
 * This file is part of the HRis Software package.
 *
 * HRis - Human Resource and Payroll System
 *
 * @link    http://github.com/HB-Co/HRis
 */

namespace HRis\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

/**
 * Class EmployeeWorkShift.
 */
class EmployeeWorkShift extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Additional fields to treat as Carbon instances.
     *
     * @var array
     */
    protected $dates = ['effective_date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'work_shift_id',
        'effective_date',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'employee_work_shifts';

    /**
     * @param null $fillables
     * @param      $employee_id
     *
     * @return null
     *
     * @author Bertrand Kintanar
     */
    public function getCurrentEmployeeWorkShift($fillables = null, $employee_id)
    {
        $employee_work_shift = $this->whereEmployeeId($employee_id)
            ->orderBy('effective_date', 'desc')
            ->orderBy('id', 'desc')
            ->first($fillables);

        return $employee_work_shift ? $employee_work_shift->toArray() : null;
    }

    /**
     * @param $start_date
     *
     * @return array
     *
     * @author Bertrand Kintanar
     */
    public function getWorkShiftRange($start_date)
    {
        $employee_work_shift = self::whereEmployeeId($this->employee_id)->where('effective_date', '<=',
            $start_date)->orderBy('id', 'desc')->first();

        $from_time_allowance = Config::get('company.from_time_allowance');
        $from_datetime = Carbon::parse($start_date.' '.$employee_work_shift->workShift->from_time)->subHour($from_time_allowance);
        $to_datetime = Carbon::parse($start_date.' '.$employee_work_shift->workShift->from_time)->addHours($employee_work_shift->workShift->duration + 1)->subSecond(1);

        return ['from_datetime' => $from_datetime, 'to_datetime' => $to_datetime];
    }

    /**
     * @param $effective_date
     *
     * @author Bertrand Kintanar
     */
    public function setEffectiveDateAttribute($effective_date)
    {
        $this->attributes['effective_date'] = Carbon::parse($effective_date) ?: null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     *
     * @author Bertrand Kintanar
     */
    public function workShift()
    {
        return $this->hasOne('HRis\Eloquent\WorkShift', 'id', 'work_shift_id');
    }
}
