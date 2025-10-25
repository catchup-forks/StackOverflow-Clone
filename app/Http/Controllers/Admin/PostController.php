<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(private readonly PostService $postService)
    {
    }

    public function update(QuestionRequest $request, Post $post): JsonResponse|RedirectResponse
    {
        $user = $request->user();

        if (! $user || ! $user->hasRole('admin')) {
            abort(403);
        }

        $updated = $this->postService->adminUpdatePost($post, $request->validated(), $user);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => trans('messages.post.admin_updated'),
                'post' => $updated,
            ]);
        }

        return redirect()
            ->route('question.show', ['question' => $updated->id])
            ->with('status', trans('messages.post.admin_updated'));
    }
}
