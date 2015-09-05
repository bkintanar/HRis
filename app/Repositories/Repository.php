<?php

namespace HRis\Repositories;

class Repository implements RepositoryInterface
{
    /**
     * Eloquent model.
     *
     * @var Eloquent
     */
    protected $model;

    /**
     * Repository constructor.
     *
     * @param Eloquent $model
     *
     * @author Harlequin Doyon
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Get all records.
     *
     * @return Collection
     *
     * @author Harlequin Doyon
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Find a certain record.
     *
     * @param int $id
     *
     * @return Eloquent
     *
     * @author Harlequin Doyon
     */
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }
}
