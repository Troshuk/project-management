<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Http\Resources\TaskResource;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * @param \App\Repositories\Interfaces\TaskRepositoryInterface $taskRepository
     */
    public function __construct(
        protected TaskRepositoryInterface $taskRepository
    ) {
    }

    /**
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index(): \Inertia\Response|\Inertia\ResponseFactory
    {
        $userId = Auth::id();

        $totalPendingTasks = $this->taskRepository->getTotalTasksCountByStatus(TaskStatus::PENDING);
        $myPendingTasks    = $this->taskRepository->getTasksCountByAssignedUserIdAndStatus($userId, TaskStatus::PENDING);

        $totalProgressTasks = $this->taskRepository->getTotalTasksCountByStatus(TaskStatus::IN_PROGRESS);
        $myProgressTasks    = $this->taskRepository->getTasksCountByAssignedUserIdAndStatus($userId, TaskStatus::IN_PROGRESS);

        $totalCompletedTasks = $this->taskRepository->getTotalTasksCountByStatus(TaskStatus::COMPLETED);
        $myCompletedTasks    = $this->taskRepository->getTasksCountByAssignedUserIdAndStatus($userId, TaskStatus::COMPLETED);

        $activeTasks = TaskResource::collection($this->taskRepository->getMostRecentActiveTasksByAssignedUserId($userId));

        return inertia(
            'Dashboard',
            compact(
                'totalPendingTasks',
                'myPendingTasks',
                'totalProgressTasks',
                'myProgressTasks',
                'totalCompletedTasks',
                'myCompletedTasks',
                'activeTasks'
            )
        );
    }
}
