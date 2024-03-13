<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;
use App\Repositories\Interfaces\ProjectRepositoryInterface;

class ProjectController extends Controller
{
    /**
     * @param \App\Repositories\Interfaces\ProjectRepositoryInterface $repository
     */
    public function __construct(
        protected ProjectRepositoryInterface $repository
    ) {
    }

    /**
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index(): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia("Project/Index", [
            'projects' => ProjectResource::collection($this->repository->getPaginated()),
        ]);
    }

    /**
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function create(): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia('Project/Create');
    }

    /**
     * @param \App\Http\Requests\ProjectCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProjectCreateRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->repository->create($request->validated());

        return to_route('project.index')
            ->with('success', 'Project was created');
    }

    /**
     * @param int $id
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function show(int $id): \Inertia\Response|\Inertia\ResponseFactory
    {
        $project = $this->repository->findOrFail($id);

        return inertia('Project/Show', [
            'project' => ProjectResource::make($project),
            'tasks'   => TaskResource::collection($this->repository->getTasksPaginated($project)),
        ]);
    }

    /**
     * @param int $id
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function edit(int $id): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia('Project/Edit', [
            'project' => new ProjectResource($this->repository->findOrFail($id)),
        ]);
    }

    /**
     * @param \App\Http\Requests\ProjectUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProjectUpdateRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $this->repository->update($id, $request->validated());

        return to_route('project.index')
            ->with('success', "Project ID:`{$id}` was updated");
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $this->repository->delete($id);

        return to_route('project.index')
            ->with('success', "Project ID`{$id}` was deleted");
    }
}
