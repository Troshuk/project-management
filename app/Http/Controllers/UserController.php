<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCrudResource;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{
    /**
     * @param \App\Repositories\Interfaces\UserRepositoryInterface $repository
     */
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {
    }

    /**
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index(): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia("User/Index", [
            "users" => UserCrudResource::collection($this->repository->getPaginated()),
        ]);
    }

    /**
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function create(): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia("User/Create");
    }

    /**
     * @param \App\Http\Requests\UserCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserCreateRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->repository->create($request->validated());

        return to_route('user.index')
            ->with('success', 'User was created');
    }

    /**
     * @param int $id
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function edit(int $id): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia('User/Edit', [
            'user' => new UserCrudResource($this->repository->findOrFail($id)),
        ]);
    }

    /**
     * @param \App\Http\Requests\UserUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $this->repository->update($id, $request->validated());

        return to_route('user.index')
            ->with('success', "User ID:`{$id}` was updated");
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $this->repository->delete($id);

        return to_route('user.index')
            ->with('success', "User ID:`{$id}` was deleted");
    }
}
