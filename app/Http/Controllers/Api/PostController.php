<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Policies\PostPolicy;
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
    /**
     * List posts
     */
    public function index(): AnonymousResourceCollection
    {
        Gate::authorize('viewAny', Post::class);

        $posts = QueryBuilder::for(Post::class)
            ->allowedIncludes(['user','comments'])
            ->allowedFilters(['title', 'body', 'name'])
            ->paginate();
        return PostResource::collection($posts);
    }

    /**
     * Create post
     *
     * @param StorePostRequest $request
     * @return JsonResponse
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        Gate::authorize('create', Post::class);

        $post = Post::create($request->validated());
        $post->syncTags($request->validated('tags'));
        return response()->json($post, 201);
    }

    /**
     * Show post
     *
     * @param Post $post
     * @return JsonResponse
     */
    public function show(Post $post): JsonResponse
    {
        Gate::authorize('view', $post);

        return response()->json($post);
    }

    /**
     * Update post
     *
     * @param UpdatePostRequest $request
     * @param Post $post
     * @return JsonResponse
     */
    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        Gate::authorize('update', $post);

        $post->update($request->validated());
        $post->syncTags($request->validated('tags'));
        return response()->json($post);
    }

    /**
     * Delete post
     *
     * @param Post $post
     * @return JsonResponse
     */
    public function destroy(Post $post): JsonResponse
    {
        Gate::authorize('delete', $post);

        $post->delete();
        return response()->json(Lang::get('post.deleted'), 204);
    }
}

