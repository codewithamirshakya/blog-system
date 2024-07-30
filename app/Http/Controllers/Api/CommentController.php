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
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

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

        return $this->successResponse(__('comment.created'),$comment, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Show comments
     *
     * @param Comment $comment
     * @return CommentResource
     */
    public function show(Comment $comment): CommentResource
    {
        return new CommentResource($comment);
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

        return $this->successResponse(__('comment.updated'),$comment, ResponseAlias::HTTP_OK);
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

        return $this->successResponse(__('comment.deleted'), [],ResponseAlias::HTTP_OK);
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

