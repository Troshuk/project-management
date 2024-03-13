<?php

namespace App\Repositories;

use App\Enums\TaskStatus;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Support\Collection;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    /**
     * @param int $userId
     * @param int|null $perPage
     * @param int $linksCountOnEachSide
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedForAssignedUserId(
        int $userId,
        ?int $perPage = 10,
        int $linksCountOnEachSide = 1
    ): \Illuminate\Contracts\Pagination\LengthAwarePaginator {
        return $this->model
            ->whereAssignedUserId($userId)
            ->sort()
            ->filter()
            ->paginate($perPage)
            ->onEachSide($linksCountOnEachSide);
    }

    /**
     * @param int $userId
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function getMostRecentActiveTasksByAssignedUserId(int $userId, int $limit = 10): Collection
    {
        return $this->model
            ->whereIn('status', [TaskStatus::PENDING, TaskStatus::IN_PROGRESS])
            ->where('assigned_user_id', $userId)
            ->limit($limit)
            ->get();
    }

    /**
     * @param int $userId
     * @param \App\Enums\TaskStatus $status
     * @return int
     */
    public function getTasksCountByAssignedUserIdAndStatus(int $userId, TaskStatus $status): int
    {
        return $this->model
            ->where('status', $status)
            ->where('assigned_user_id', $userId)
            ->count();
    }

    /**
     * @param \App\Enums\TaskStatus $status
     * @return int
     */
    public function getTotalTasksCountByStatus(TaskStatus $status): int
    {
        return $this->model
            ->where('status', $status)
            ->count();
    }
}
