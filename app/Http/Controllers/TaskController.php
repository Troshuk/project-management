<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\UserResource;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct(
        protected TaskRepositoryInterface $repository,
        protected ProjectRepositoryInterface $projectRepository,
        protected UserRepositoryInterface $userRepository
    ) {
    }

    /**
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index(): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia("Task/Index", [
            "tasks" => TaskResource::collection($this->repository->getPaginated()),
        ]);
    }

    /**
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function create(): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia("Task/Create", [
            'projects' => ProjectResource::collection($this->projectRepository->getAll()),
            'users'    => UserResource::collection($this->userRepository->getAll()),
        ]);
    }

    /**
     * @param \App\Http\Requests\TaskCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TaskCreateRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->repository->create($request->validated());

        return to_route('task.index')
            ->with('success', 'Task was created');
    }

    /**
     * @param int $id
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function show(int $id): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia('Task/Show', [
            'task' => new TaskResource($this->repository->find($id)),
        ]);
    }

    /**
     * @param int $id
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function edit(int $id): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia("Task/Edit", [
            'task'     => TaskResource::make($this->repository->findOrFail($id)),
            'projects' => ProjectResource::collection($this->projectRepository->getAll()),
            'users'    => UserResource::collection($this->userRepository->getAll()),
        ]);
    }

    /**
     * @param \App\Http\Requests\TaskUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TaskUpdateRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $this->repository->update($id, $request->validated());

        return to_route('task.index')
            ->with('success', "Task ID:`{$id}` was updated");
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $this->repository->delete($id);

        return to_route('task.index')
            ->with('success', "Task ID:`{$id}` was deleted");
    }

    /**
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function myTasks(): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia("Task/Index", [
            "tasks"        => TaskResource::collection($this->repository->getPaginatedForAssignedUserId(Auth::id())),
            'currentRoute' => route('task.myTasks'),
        ]);
    }
}
