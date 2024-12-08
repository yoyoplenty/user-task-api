<?php

namespace App\Repositories;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Prettus\Repository\Eloquent\BaseRepository as Repository;

abstract class BaseRepository extends Repository {

    public abstract function model();

    /**
     * Bulk create records.
     *
     * @param array $data
     * @return bool
     */
    public function bulkCreate(array $data) {
        return $this->model->insert($data);
    }

    /**
     * THIS FUNCTION ACCEPTS QUERY FILTER BY DEFAULT
     * @return mixed
     */
    public function findAll(array $query = [], $perPage = 20) {
        $queryBuilder = $this->model->newQuery();

        if (!empty($query))  $queryBuilder->where($query);
        else $queryBuilder->filter();

        return $queryBuilder->paginate($perPage);
    }


    /**
     * Find records with search and query conditions.
     *
     * @param array $searchFields
     * @param string|null $searchParam
     * @param array $query
     * @param array|null $rel
     * @param int $perPage
     * @return mixed
     */
    public function findAndSearch(
        ?array $searchFields,
        ?string $searchParam,
        array $query = [],
        ?array $rel = null,
        int $perPage = 20,
        ?array $joinSearchFields = null,
    ) {
        $queryBuilder = $this->model->newQuery();

        if (array_key_exists('search', $query)) unset($query['search']);
        foreach ($query as $key => $value) $queryBuilder->where($key, '=', $value);

        if ($searchParam) {
            $queryBuilder->where(function (Builder $query) use ($searchFields, $searchParam, $joinSearchFields) {
                if (!empty($searchFields)) {
                    $query->orWhere(function (Builder $subQuery) use ($searchFields, $searchParam) {
                        foreach ($searchFields as $field) {
                            $subQuery->orWhere($field, 'LIKE', '%' . $searchParam . '%');
                        }
                    });
                }

                if (!empty($joinSearchFields)) {
                    foreach ($joinSearchFields as $relation => $fields) {
                        if (method_exists($this->model, $relation)) {
                            $query->orWhereHas($relation, function (Builder $joinQuery) use ($fields, $searchParam) {
                                $joinQuery->where(function (Builder $innerQuery) use ($fields, $searchParam) {
                                    foreach ($fields as $field) {
                                        $innerQuery->orWhere($field, 'LIKE', '%' . $searchParam . '%');
                                    }
                                });
                            });
                        }
                    }
                }
            });
        }

        if (!empty($rel)) {
            $validRelationships = array_filter($rel, fn($relationship) => method_exists($this->model, $relationship));
            $queryBuilder->with($validRelationships);
        }

        return $queryBuilder->paginate($perPage);
    }

    public function findAndOrder(array $where, $columns = ['*'], $orderBy = 'created_at', $sort = 'DESC') {
        $this->applyCriteria();
        $this->applyScope();

        $this->applyConditions($where);

        $model = $this->model->orderBy($orderBy, $sort)->get($columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

    /**
     * Update multiple records based on a given query.
     *
     * @param array $data
     * @param array $query
     * @return mixed
     */
    public function updateMany(array $query, array $data) {
        try {
            return $this->model->where($query)->update($data);
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * @param string $column
     * @param string $direction
     * @return mixed
     */
    public function orderBy($column = 'id', $direction = 'desc') {
        return $this->model->orderBy($column, $direction);
    }

    /**
     * @param array $data
     * @param string $id
     * @return mixed
     */
    public function updateById(array $data, string $id) {
        try {
            return tap($this->model::where('id', $id)->first())->update($data)->fresh();
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    /**
     * @param array $query
     * @return mixed
     */
    public function deleteMany(array $ids) {
        return $this->model->whereIn('id', $ids)->delete();
    }
}
