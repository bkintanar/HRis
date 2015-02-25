<?php namespace HRis\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeWorkShift
 * @package HRis
 */
class EmployeeWorkShift extends Model {

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $dates = ['effective_date'];

    /**
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
     * @param $employee_id
     * @return mixed
     */
    public function getCurrentEmployeeWorkShift($fillables = null, $employee_id)
    {
        return $this->whereEmployeeId($employee_id)
            ->orderBy('effective_date', 'desc')
            ->orderBy('id', 'desc')
            ->first($fillables)->toArray();
    }

    /**
     * @param $start_date
     * @return array
     */
    public function getTimeLogSpan($start_date)
    {
        // TODO: Add these to config
        $from_datetime = Carbon::parse($start_date . ' ' . $this->workShift->from_time)->subHour(1);
        $to_datetime = Carbon::parse($from_datetime)->addHours(14)->subSecond(1);

        return ['from_datetime' => $from_datetime, 'to_datetime' => $to_datetime];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function workShift()
    {
        return $this->hasOne('HRis\Eloquent\WorkShift', 'id', 'work_shift_id');
    }
}
