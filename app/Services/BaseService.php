<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

abstract class BaseService
{
    public function __construct(public BaseRepository $repository)
    {
    }

    public function getData(
        array $relations = [],
        bool $usePagination = true,
        int $perPage = 30,
        array $filters = [],
        array $sorts = [],
        array $scopes = [],
        array $counts = [],
        array $columns = ['*']
    )
    {
        $query = $this->repository
            ->withRelations($relations)
            ->withScopes($scopes)
            ->withFilter($filters)
            ->withSort($sorts)
            ->withCount($counts)
            ->withSelect($columns);
        return $usePagination ? $query->cursorPaginate($perPage) : $query->all();
    }


    public function storeResource(array $data): Model
    {
        return $this->repository->create($data);
    }

    public function showResource($id, array $relations = [],array $scopes = [])
    {
        return $this->repository->withRelations($relations)->withScopes($scopes)->find($id);
    }

    public function updateResource($id, $data)
    {
        return $this->repository->update($data, $id);
    }

    public function deleteResource($id): void
    {
        $this->repository->delete($id);
    }

    public function storeResourceDescriptions($model,array $descriptionData){
        return $model->addDescription($descriptionData);
    }

    public function getBy(array $conditions): Collection
    {
        return $this->repository->getBy($conditions);
    }

    public function findBy(array $conditions, ?string $errorMessage = null){
        return $this->repository->findBy($conditions,$errorMessage);
    }

    public function first(string $columnName, string $operator , string $value ,array $relations = [],array $scopes = []){
        return $this->repository->withRelations($relations)->withScopes($scopes)->firstBy([[$columnName,$operator,$value]]);
    }

    public function firstBy(array $conditions, ?string $orderByColumn = null, string $direction = 'desc'){
        return $this->repository->firstBy($conditions,$orderByColumn,$direction);
    }

    public function whereHas(string $relation, Closure $callback): QueryBuilder
    {
        return $this->repository->whereHas($relation, $callback);
    }

    public function firstOrCreate(array $data,array $conditions = []){
        return $this->repository->firstOrCreate($data, $conditions);
    }

    public function updateOrCreate(array $conditions,array $data){
        return $this->repository->updateOrCreate($conditions, $data);
    }
}
