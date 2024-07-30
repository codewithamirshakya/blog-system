<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

#[Group("User management", "APIs for managing users")]
#[Authenticated]
class UserController extends Controller
{
    /**
     * User list
     *
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny');
        $users = QueryBuilder::for(User::class)
            ->allowedFilters(['name', 'email'])
            ->paginate();

        return UserResource::collection($users);

    }

    /**
     * Create User
     *
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        Gate::authorize('store');
        $user = User::create($request->validated());

        return $this->successResponse(__('user.created'),$user, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Show user
     *
     * Display the specified resource.
     */
    public function show(User $user): UserResource
    {
        Gate::authorize('view');
        return UserResource::make($user);
    }

    /**
     * Update user
     *
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        Gate::authorize('update');
        $user->update($request->validated());

        return $this->successResponse(__('user.updated'),$user, ResponseAlias::HTTP_OK);
    }

    /**
     * Delete user
     *
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        Gate::authorize('delete');
        $user->delete();

        return $this->successResponse(__('user.deleted'), [],ResponseAlias::HTTP_OK);
    }
}
