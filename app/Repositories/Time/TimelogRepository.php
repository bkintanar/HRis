<?php

namespace HRis\Repositories\Time;

use HRis\Eloquent\Timelog;
use HRis\Repositories\Repository;

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
     * @return Collection
     *
     * @author Harlequin Doyon
     */
    public function paginate($id = null, $sort = 'id', $direction = 'asc')
    {
        if (is_null($id)) {
            return $this->model->paginate(DATAS_PER_PAGE);
        }

        return $this->model->whereEmployeeId($id)
                ->orderBy($sort, $direction)
                ->paginate(DATAS_PER_PAGE);
    }

    /**
     * Fetch the latest record of the table.
     *
     * @return Eloquent
     *
     * @author Harlequin Doyon
     */
    public function latest()
    {
        return $this->model->orderBy('created_at', 'desc')->first();
    }

    /**
     * Check the latest timelog if user has no time in.
     *
     * @return Eloquent
     *
     * @author Harlequin Doyon
     */
    public function hasNoLatestTimein()
    {
        $timelog = $this->latest();
        
        if (! isset($timelog) || (!empty($timelog->in) && !empty($timelog->out))) {
            return true;
        }

        return false;
    }

    /**
     * Check the latest timelog if user has no time out.
     *
     * @return bool
     *
     * @author Harlequin Doyon
     */
    public function hasNoLatestTimeout()
    {
        $timelog = $this->latest();

        if (isset($timelog) && is_null($timelog->out)) {
            return true;
        }

        return false;
    }
}
