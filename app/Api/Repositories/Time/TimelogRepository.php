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
 
namespace HRis\Api\Repositories\Time;

use HRis\Api\Eloquent\Employee;
use HRis\Api\Eloquent\Timelog;
use HRis\Api\Repositories\Repository;

class TimelogRepository extends Repository
{
    /**
     * TimelogRepository constructor.
     *
     * @author Harlequin Doyon
     */
    public function __construct()
    {
        parent::__construct(new Timelog());
    }

    /**
     * Pagination.
     *
     * @param int    $id
     * @param string $sort
     * @param string $direction
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     *
     * @author Harlequin Doyon
     */
    public function paginate($id = null, $sort = 'id', $direction = 'asc')
    {
        if (is_null($id)) {
            return $this->model->paginate(ROWS_PER_PAGE);
        }

        return $this->model->whereEmployeeId($id)
            ->orderBy($sort, $direction)
            ->paginate(ROWS_PER_PAGE);
    }

    /**
     * Check the latest timelog if user has no time in.
     *
     * @param Employee $employee
     *
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @author Harlequin Doyon
     */
    public function hasNoLatestTimein(Employee $employee)
    {
        $timelog = $this->latest($employee);

        if (!isset($timelog) || (!empty($timelog->in) && !empty($timelog->out))) {
            return true;
        }

        return false;
    }

    /**
     * Fetch the latest record of the table.
     *
     * @param Employee $employee
     *
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @author Harlequin Doyon
     */
    public function latest(Employee $employee)
    {
        return $this->model->where('employee_id', $employee->id)->orderBy('created_at', 'desc')->first();
    }

    /**
     * Check the latest timelog if user has no time out.
     *
     * @param Employee $employee
     *
     * @return bool
     *
     * @author Harlequin Doyon
     */
    public function hasNoLatestTimeout(Employee $employee)
    {
        $timelog = $this->latest($employee);

        if (isset($timelog) && is_null($timelog->out)) {
            return true;
        }

        return false;
    }

    /**
     * Returns timelog in a given range.
     *
     * @param $start
     * @param $end
     * @param $employee_id
     * @param $rows_per_page
     *
     * @return mixed
     */
    public function range($start, $end, $employee_id, $rows_per_page)
    {
        return $this->model
            ->whereBetween('in', [$start, $end])
            ->where('employee_id', $employee_id)
            ->select('id', 'employee_id', 'in', 'out', 'rendered_hours', 'created_at')
            ->orderBy('id', 'desc')
            ->paginate($rows_per_page);
    }
}
