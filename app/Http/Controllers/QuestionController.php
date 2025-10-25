<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request): JsonResponse|RedirectResponse
    {
        $questions = $this->postService->listQuestions();

        if ($request->wantsJson()) {
            return response()->json($questions);
        }

        return redirect()->route('filament.app.resources.questions.index');
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('filament.app.resources.questions.create');
    }

    public function store(QuestionRequest $request): RedirectResponse|JsonResponse
    {
        $user = $request->user();
        abort_if(! $user, 403);

        $question = $this->postService->createQuestion($request->validated(), $user);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => trans('messages.question.created'),
                'question' => $question,
            ], 201);
        }

        return redirect()->route('filament.app.resources.questions.view', ['record' => $question->getKey()]);
    }

    public function show(Request $request, int $questionId): RedirectResponse|JsonResponse
    {
        $question = $this->postService->findQuestion($questionId);

        if ($request->wantsJson()) {
            return response()->json([
                'post' => $question,
                'answers' => $this->postService->answersForQuestion($question),
            ]);
        }

        return redirect()->route('filament.app.resources.questions.view', ['record' => $question->getKey()]);
    }

    public function edit(int $questionId): RedirectResponse
    {
        $question = $this->postService->findQuestion($questionId);
        return redirect()->route('filament.app.resources.questions.edit', ['record' => $question->getKey()]);
    }

    public function update(QuestionRequest $request, int $questionId): RedirectResponse|JsonResponse
    {
        $question = $this->postService->findQuestion($questionId);
        $user = $request->user();
        abort_if(! $user, 403);

        $updated = $this->postService->updateQuestion($question, $request->validated(), $user);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => trans('messages.question.updated'),
                'question' => $updated,
            ]);
        }

        return redirect()->route('filament.app.resources.questions.view', ['record' => $updated->getKey()]);
    }

    public function destroy(Request $request, int $questionId): RedirectResponse|JsonResponse
    {
        $question = $this->postService->findQuestion($questionId);
        $this->postService->deleteQuestion($question);

        if ($request->wantsJson()) {
            return response()->json(['message' => trans('messages.question.deleted')]);
        }

        return redirect()->route('filament.app.resources.questions.index')->with('status', trans('messages.question.deleted'));
    }
}
