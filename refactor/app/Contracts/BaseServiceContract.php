<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Interface for base service operations.
 */
interface BaseServiceContract
{
    /**
     * Retrieve all records.
     *
     * @return Collection
     */
    public function all(): Collection;


    /**
     * Store a new record in the database.
     *
     * @param array $data Data to create a new record.
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * Retrieve a record by its primary key.
     *
     * @param int $id The primary key.
     * @return Model|null
     */
    public function find(int $id): ?Model;

    /**
     * Update the specified record in the database.
     *
     * @param int $id The primary key.
     * @param array $data Data to update the record.
     * @return Model
     */
    public function update(int $id, array $data): Model;

    /**
     * Delete the specified record from the database.
     *
     * @param int $id The primary key.
     * @return bool|null True on success, null otherwise.
     */
    public function delete(int $id): ?bool;
}