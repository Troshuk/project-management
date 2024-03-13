<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Model $model);

    /**
     * @param int|string $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find(string|int $id): ?Model;

    /**
     * @param int|string $id
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException<\Illuminate\Database\Eloquent\Model>
     */
    public function findOrFail(string|int $id): Model;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getAll(): Collection;

    /**
     * @param int|null $perPage
     * @param int $linksCountOnEachSide
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginated(
        ?int $perPage = 10,
        int $linksCountOnEachSide = 1
    ): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function create(array $data): ?Model;

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool;
}
