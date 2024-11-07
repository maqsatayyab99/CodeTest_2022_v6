<?php

namespace App\Services;

use App\Contracts\BaseServiceContract;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\BaseRepositoryContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Abstract base service class.
 */
abstract class BaseService implements BaseServiceContract
{
    protected BaseRepositoryContract $repository;

    /**
     * BaseService constructor.
     *
     * @param BaseRepositoryContract $repository
     */
    public function __construct(BaseRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all models with optional relations.
     *
     * @param array $data
     * @param array|null $withRelations
     * @return Collection
     */
    public function all(): Collection {
        return $this->repository->all();
    }

    /**
     * Store a new model.
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model {
        return $this->repository->create($data);
    }

    /**
     * Get a model by ID with optional relations.
     *
     * @param int $id
     * @param array|null $withRelations
     * @return Model|null
     */
    public function find(int $id, ?array $withRelations = []): ?Model {
        return $this->repository->find($id, $withRelations);
    }

    /**
     * Update a model by ID.
     *
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data): Model {
        return $this->repository->update($id, $data);
    }

    /**
     * Delete a model by ID.
     *
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool {
        return $this->repository->delete($id);
    }
}
