<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;
use Spatie\QueryBuilder\QueryBuilder;

#[Group("Post management", "APIs for managing posts")]
#[Authenticated]
class PostController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny');

        $posts = QueryBuilder::for(Post::class)
            ->allowedIncludes(['user','comments'])
            ->allowedFilters(['title', 'body', 'name'])
            ->paginate();
        return PostResource::collection($posts);
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        Gate::authorize('create');

        $post = Post::create($request->validated());
        return response()->json($post, 201);
    }

    public function show(Post $post): JsonResponse
    {
        Gate::authorize('view', $post);

        return response()->json($post);
    }

    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        Gate::authorize('update', $post);

        $post->update($request->validated());
        return response()->json($post);
    }

    public function destroy(Post $post): JsonResponse
    {
        Gate::authorize('delete', $post);

        $post->delete();
        return response()->json(Lang::get('post.deleted'), 204);
    }
}

