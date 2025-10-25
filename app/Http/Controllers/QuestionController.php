<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Services\PostService;
use App\Services\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionController extends Controller
{
    protected PostService $postService;

    protected TagService $tagService;

    public function __construct(PostService $postService, TagService $tagService)
    {
        $this->postService = $postService;
        $this->tagService = $tagService;
    }

    public function index(Request $request): JsonResponse|View
    {
        $questions = $this->postService->listQuestions();

        if ($request->wantsJson()) {
            return response()->json($questions);
        }

        return view('public.questions.index', ['questions' => $questions]);
    }

    public function create(): View
    {
        return view('public.question.create', [
            'tags' => $this->postService->recentTags(),
            'selectedTags' => [],
        ]);
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

        return redirect()
            ->route('question.show', ['question' => $question->id])
            ->with('status', trans('messages.question.created'));
    }

    public function show(int $questionId): View
    {
        $question = $this->postService->findQuestion($questionId);

        return view('public.question.index', [
            'post' => $question,
            'answers' => $this->postService->answersForQuestion($question),
        ]);
    }

    public function edit(int $questionId): View
    {
        $question = $this->postService->findQuestion($questionId);
        $selectedTags = collect(explode(',', (string) $question->tags))
            ->map(fn (string $tag) => trim($tag))
            ->filter()
            ->values();

        $selectedTagIds = $this->tagService->idsByNames($selectedTags->all());

        return view('public.question.edit', [
            'question' => $question,
            'tags' => $this->postService->recentTags(),
            'selectedTags' => $selectedTagIds,
        ]);
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

        return redirect()
            ->route('question.show', ['question' => $updated->id])
            ->with('status', trans('messages.question.updated'));
    }

    public function destroy(Request $request, int $questionId): RedirectResponse|JsonResponse
    {
        $question = $this->postService->findQuestion($questionId);
        $this->postService->deleteQuestion($question);

        if ($request->wantsJson()) {
            return response()->json(['message' => trans('messages.question.deleted')]);
        }

        return redirect()->route('questions.index')->with('status', trans('messages.question.deleted'));
    }
}
