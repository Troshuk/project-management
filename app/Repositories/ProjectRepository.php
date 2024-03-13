<?php

namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepositoryInterface;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{
    /**
     * @param int|string $id
     * @return \App\Models\Project
     */
    public function findOrFail(int|string $id): Project
    {
        return parent::findOrFail($id);
    }

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
    ): \Illuminate\Contracts\Pagination\LengthAwarePaginator {
        return $project
            ->tasks()
            ->sort()
            ->filter()
            ->paginate($perPage)
            ->onEachSide($linksCountOnEachSide);
    }
}
