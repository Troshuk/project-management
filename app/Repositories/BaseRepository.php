<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(
        protected Model $model
    ) {
    }

    /**
     * @param int|string $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find(int|string $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * @param int|string $id
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException<\Illuminate\Database\Eloquent\Model>
     */
    public function findOrFail(int|string $id): Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * @param int|null $perPage
     * @param int $linksCountOnEachSide
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginated(
        ?int $perPage = 10,
        int $linksCountOnEachSide = 1
    ): \Illuminate\Contracts\Pagination\LengthAwarePaginator {
        return $this->model
            ->sort()
            ->filter()
            ->paginate($perPage)
            ->onEachSide($linksCountOnEachSide);
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function create(array $data): ?Model
    {
        return $this->model->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->model->whereId($id)->update($data);
    }

    /**
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool
    {
        return $this->model->whereId($id)->delete();
    }
}
