<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store(CommentRequest $request): JsonResponse|RedirectResponse
    {
        $user = $request->user();
        abort_if(! $user, 403);

        $comment = $this->commentService->create($request->validated(), $user);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => trans('messages.comment.created'),
                'comment' => $comment,
            ], 201);
        }

        return redirect()
            ->route('question.show', ['question' => $comment->post_id])
            ->with('status', trans('messages.comment.created'));
    }

    public function update(CommentRequest $request, Comment $comment): JsonResponse|RedirectResponse
    {
        $user = $request->user();
        abort_if(! $user, 403);

        $comment = $this->commentService->update($comment, $request->validated());

        if ($request->wantsJson()) {
            return response()->json([
                'message' => trans('messages.comment.updated'),
                'comment' => $comment,
            ]);
        }

        return redirect()
            ->route('question.show', ['question' => $comment->post_id])
            ->with('status', trans('messages.comment.updated'));
    }

    public function flag(Request $request, Comment $comment): JsonResponse|RedirectResponse
    {
        abort_if(! $request->user(), 403);
        $comment = $this->commentService->flagForAdmin($comment);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => trans('messages.comment.flagged'),
                'comment' => $comment,
            ]);
        }

        return redirect()->back()->with('status', trans('messages.comment.flagged'));
    }

    public function adminUpdate(CommentRequest $request, Comment $comment): JsonResponse|RedirectResponse
    {
        $user = $request->user();

        if (! $user || ! $user->hasRole('admin')) {
            abort(403);
        }

        $comment = $this->commentService->adminUpdate($comment, $request->validated(), $user);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => trans('messages.comment.admin_updated'),
                'comment' => $comment,
            ]);
        }

        return redirect()
            ->route('question.show', ['question' => $comment->post_id])
            ->with('status', trans('messages.comment.admin_updated'));
    }
}
