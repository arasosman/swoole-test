<?php

namespace App\Repositories;

use App\Repositories\Contracts\BaseRepositoryContract;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository
 * @package App\Repositories
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class BaseRepository implements BaseRepositoryContract
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct(Model $model = null)
    {
        if ($model) {
            $this->model = $model;
        }
    }

    public function find($entityId)
    {
        return $this->model->find($entityId);
    }

    public function findWith(int $entityId, array $with)
    {
        return $this->model->with($with)->find($entityId);
    }

    public function findIncludingTrashed(int $entityId)
    {
        return $this->model->withTrashed()->find($entityId);
    }

    public function findWithIncludingTrashed(int $entityId, array $with)
    {
        return $this->model->withTrashed()->with($with)->find($entityId);
    }

    public function firstOrCreate($attributes)
    {
        return $this->model->firstOrCreate($attributes);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function allWith(array $with)
    {
        return $this->model->with($with)->get();
    }

    public function paginate($params = [])
    {
        return $this->model->paginate($params);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function updateOrCreate($attributes, $values = [])
    {
        $this->model->updateOrCreate($attributes, $values);
    }

    public function update($model, $data)
    {
        $model->fill($data)->save();
        return $model;
    }

    public function destroy($model)
    {
        return $model->delete();
    }

    public function purge($model)
    {
        return $model->forceDelete();
    }

    public function findByAttributes(array $attributes)
    {
        return $this->model->where($attributes)->first();
    }

    public function findManyByAttributes(array $attributes)
    {
        return $this->model->where($attributes)->get();
    }

    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param $model
     * @return BaseRepository
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }
}
