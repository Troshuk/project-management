<?php

namespace App\Repositories\Interfaces;

use App\Enums\TaskStatus;
use Illuminate\Support\Collection;

interface TaskRepositoryInterface extends BaseRepositoryInterface
{
    public function getPaginatedForAssignedUserId(
        int $userId,
        ?int $perPage = 10,
        int $linksCountOnEachSide = 1
    ): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    /**
     * @param int $userId
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function getMostRecentActiveTasksByAssignedUserId(int $userId, int $limit = 10): Collection;

    /**
     * @param int $userId
     * @param \App\Enums\TaskStatus $status
     * @return int
     */
    public function getTasksCountByAssignedUserIdAndStatus(int $userId, TaskStatus $status): int;

    /**
     * @param \App\Enums\TaskStatus $status
     * @return int
     */
    public function getTotalTasksCountByStatus(TaskStatus $status): int;
}
