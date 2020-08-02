<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class Base
{
    /**
     * @var Model|null
     */
    protected $model;

    abstract public function getModelClass(): string;

    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    public function findById($id): ?Model
    {
        return $this->model->find($id);
    }

    public function delete(int $id): void
    {
        $model = $this->findById($id);
        $model->delete();
    }
}
