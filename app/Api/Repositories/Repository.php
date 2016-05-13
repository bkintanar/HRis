<?php

namespace HRis\Api\Repositories;

class Repository implements RepositoryInterface
{
    /**
     * Eloquent model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Repository constructor.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
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
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @author Harlequin Doyon
     */
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }
}
