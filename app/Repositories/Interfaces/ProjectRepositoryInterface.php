<?php

namespace App\Repositories\Interfaces;

use App\Models\Project;

interface ProjectRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @param int|string $id
     * @return \App\Models\Project
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(string|int $id): Project;

    /**
     * @param \App\Models\Project $project
     * @param int|null $perPage
     * @param int $linksCountOnEachSide
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getTasksPaginated(
        Project $project,
        ?int $perPage = 10,
        int $linksCountOnEachSide = 1
    ): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
}
