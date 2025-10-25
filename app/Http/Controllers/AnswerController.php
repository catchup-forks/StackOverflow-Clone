<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnswerRequest;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnswerController extends Controller
{
    public function __construct(private readonly PostService $postService)
    {
    }

    public function index(Request $request): JsonResponse|View
    {
        $answers = $this->postService->paginateAnswers();

        if ($request->wantsJson()) {
            return response()->json($answers);
        }

        return view('public.answer.index', ['answers' => $answers]);
    }

    public function store(AnswerRequest $request): JsonResponse|RedirectResponse
    {
        $user = $request->user();
        abort_if(! $user, 403);

        $answer = $this->postService->createAnswer($request->validated(), $user);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => trans('messages.answer.created'),
                'answer' => $answer->load(['user', 'votes']),
            ], 201);
        }

        return redirect()
            ->route('question.show', ['question' => $answer->parent_id])
            ->with('status', trans('messages.answer.created'));
    }

    public function show(Request $request, int $answerId): JsonResponse|RedirectResponse
    {
        $answer = $this->postService->findAnswer($answerId);

        if ($request->wantsJson()) {
            return response()->json($answer);
        }

        if ($answer->parent_id) {
            return redirect()->route('question.show', ['question' => $answer->parent_id]);
        }

        return redirect()->route('questions.index')->with('status', trans('messages.answer.missing_parent'));
    }

    public function edit(int $answerId): View
    {
        $answer = $this->postService->findAnswer($answerId);
        $question = $answer->parent_id ? $this->postService->findQuestion($answer->parent_id) : null;

        return view('public.answer.edit', [
            'answer' => $answer,
            'question' => $question,
        ]);
    }

    public function update(AnswerRequest $request, int $answerId): JsonResponse|RedirectResponse
    {
        $answer = $this->postService->findAnswer($answerId);
        $user = $request->user();
        abort_if(! $user, 403);

        $updated = $this->postService->updateAnswer($answer, $request->validated(), $user);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => trans('messages.answer.updated'),
                'answer' => $updated->load(['user', 'votes']),
            ]);
        }

        return redirect()
            ->route('question.show', ['question' => $updated->parent_id])
            ->with('status', trans('messages.answer.updated'));
    }

    public function destroy(Request $request, int $answerId): JsonResponse|RedirectResponse
    {
        $answer = $this->postService->findAnswer($answerId);
        $questionId = $answer->parent_id;

        $this->postService->deleteAnswer($answer);

        if ($request->wantsJson()) {
            return response()->json(['message' => trans('messages.answer.deleted')]);
        }

        if ($questionId) {
            return redirect()
                ->route('question.show', ['question' => $questionId])
                ->with('status', trans('messages.answer.deleted'));
        }

        return redirect()->route('questions.index')->with('status', trans('messages.answer.deleted'));
    }
}
