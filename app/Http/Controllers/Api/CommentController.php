<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post; // Import other models as needed
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;

#[Group("Comment management", "APIs for managing comments")]
#[Authenticated]
class CommentController extends Controller
{
    /**
     * List comments for morphic model
     *
     * @throws Exception
     */
    public function index(string $type, int $id): AnonymousResourceCollection
    {
        $model = $this->getModel($type);
        $instance = $model::findOrFail($id);

        return CommentResource::collection($instance->comments);

    }

    /**
     * Create comments for morphic model
     *
     * @throws Exception
     */
    public function store(StoreCommentRequest $request, string $type, int $id): JsonResponse
    {

        $model = $this->getModel($type);
        /** @var Comment $instance */
        $instance = $model::findOrFail($id);

        $comment = $instance->comments()->create($request->all());

        return response()->json($comment, 201);
    }

    /**
     * Show comments
     *
     * @param Comment $comment
     * @return JsonResponse
     */
    public function show(Comment $comment): JsonResponse
    {
        return response()->json($comment);
    }

    /**
     * Update comment
     *
     * @param UpdateCommentRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateCommentRequest $request, int $id): JsonResponse
    {
        $comment = Comment::findOrFail($id);

        Gate::authorize('update', $comment);

        $comment->update($request->all());

        return response()->json($comment);
    }

    /**
     * Delete comments
     *
     * @param Comment $comment
     * @return JsonResponse
     */
    public function destroy(Comment $comment): JsonResponse
    {
        $comment->delete();

        return response()->json(null, 204);
    }

    /**
     * @throws Exception
     */
    private function getModel($type): string
    {
        return match ($type) {
            'post' => Post::class,
            default => throw new Exception("Invalid type"),
        };
    }
}

