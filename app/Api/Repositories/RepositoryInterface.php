<?php

namespace HRis\Api\Repositories;

interface RepositoryInterface
{
    public function all();

    public function find($id);
}
