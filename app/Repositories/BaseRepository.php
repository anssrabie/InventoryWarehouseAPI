<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\{Collection, Model};
use Closure;
use Illuminate\Pagination\CursorPaginator;
use Spatie\QueryBuilder\QueryBuilder;

class BaseRepository
{
    protected array $relations = [];
    protected array $scopes = [];
    protected array $filters = [];
    protected array $sorts = [];
    protected array $withCount = [];
    protected array $columns = ['*'];
    protected $modelClass;
    public function __construct(public $model)
    {
        $this->modelClass = get_class($this->model);
    }

    public function query(): QueryBuilder
    {
        $query = QueryBuilder::for($this->modelClass)
            ->select($this->columns)
            ->scopes($this->scopes)
            ->with($this->relations)
            ->withCount($this->withCount);

        if (!empty($this->filters)) {
            $query->allowedFilters($this->filters);
        }
        if (!empty($this->sorts)) {
            $query->allowedSorts($this->sorts);
        }

        return $query;
    }


    public function withRelations($relations): static
    {
        $this->relations = $relations;
        return $this;
    }

    public function withScopes(array $scopes): static
    {
        $this->scopes = $scopes;
        return $this;
    }

    public function withCount(array $counts): static
    {
        $this->withCount = $counts;
        return $this;
    }

    public function all(): Collection
    {
        return $this->query()->latest()->get();
    }

    public function withSelect(array $columns): static
    {
        $this->columns = $columns;
        return $this;
    }

    public function cursorPaginate($perPage = 30): CursorPaginator
    {
        return $this->query()->latest('id')->cursorPaginate($perPage);
    }

    public function withFilter(array $filters): static
    {
        $this->filters = $filters;
        return $this;
    }

    public function withSort(array $sorts): static
    {
        $this->sorts = $sorts;
        return $this;
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function find(int|string $id)
    {
        return $this->query()->findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $modelObject = $this->find($id);
        $modelObject->update($data);
        $modelObject->refresh();
        return $modelObject;
    }


    public function getBy(array $conditions): Collection
    {
        return $this->query()->where($conditions)->get();
    }

    public function findBy(array $conditions,?string $errorMessage = null)
    {
        try {
            return $this->query()->where($conditions)->firstOrFail();
        } catch (\Exception $e) {
            $modelName = class_basename($this->model);
            $errorMessage = $errorMessage ?? "No matching {$modelName} found with the provided conditions.";
            throw new \Exception($errorMessage);
        }
    }

    public function firstBy(array $conditions, ?string $orderByColumn = null, string $direction = 'desc')
    {
        $query = $this->query()->where($conditions);
        if ($orderByColumn) {
            $query = $query->orderBy($orderByColumn, $direction);
        }
        return $query->first();
    }

    public function firstWhere(array $conditions)
    {
        return $this->query()->firstWhere($conditions);
    }

    public function allWhere(array $conditions): Collection
    {
        return $this->query()->where($conditions)->get();
    }

    public function whereIn(string $column, array $values): QueryBuilder
    {
        return $this->query()->whereIn($column, $values);
    }


    public function whereHas(string $relation, Closure $callback): QueryBuilder
    {
        return $this->query()->whereHas($relation, $callback);
    }

    public function updateOrCreate(array $conditions, array $data)
    {
        return $this->query()->updateOrCreate($conditions, $data);
    }

    public function firstOrCreate(array $data,array $conditions = [])
    {
        return $this->query()->firstOrCreate($conditions, $data);
    }

    public function exists(array $conditions): bool
    {
        return $this->query()->where($conditions)->exists();
    }

    public function delete($id)
    {
        return $this->query()->findOrFail($id)->delete();
    }

    public function deleteBy(array $conditions): mixed
    {
        return $this->query()->where($conditions)->delete();
    }

    public function destroy(array $ids)
    {
        return $this->model->destroy($ids);
    }
}
