<?php

namespace HRis\Repositories;

interface RepositoryInterface
{
    public function all();
    public function find($id);
}
