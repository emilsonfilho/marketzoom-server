<?php

namespace App\Http\Controllers;

use App\Exceptions\NotAllowedException;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Knuckles\Scribe\Attributes\Group;
use Symfony\Component\HttpFoundation\Response;

#[Group(name: 'Comentários', description: 'Gestão de comentários')]
class CommentController extends Controller
{
    /**
     * POST api/comments
     *
     * Store a newly created comment in storage.
     */
    public function store(StoreCommentRequest $request): JsonResponse
    {
        if (Gate::denies('is-user')) return NotAllowedException::notAllowed();

        $result = Comment::create($request->validated());

        return response()->json(new CommentResource($result->load(['user', 'product'])));
    }

    /**
     * GET api/comments/{comment}
     *
     * Display the specified comment.
     */
    public function show(Comment $comment): JsonResponse
    {
        return response()->json(new CommentResource($comment->load(['user', 'product'])));
    }

    /**
     * PUT api/commnts/{comment}
     *
     * Update the specified comment in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment): JsonResponse
    {
        if (Gate::denies('update-comment')) return NotAllowedException::notAllowed();

        $comment->update($request->validated());

        return response()->json(new CommentResource($comment->load(['user', 'product'])));
    }

    /**
     * DELETE api/comments/{comment}
     *
     * Remove the specified comment from storage.
     */
    public function destroy(Comment $comment): JsonResponse
    {
        if (Gate::denies('delete-comment')) return NotAllowedException::notAllowed();

        $comment->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
