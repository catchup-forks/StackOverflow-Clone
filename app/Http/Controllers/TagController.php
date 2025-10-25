<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TagController extends Controller
{
    protected TagService $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index(Request $request): JsonResponse|View
    {
        $tags = $this->tagService->paginate();

        if ($request->wantsJson()) {
            return response()->json($tags);
        }

        return view('public.tags.index', ['tags' => $tags]);
    }

    public function create(): View
    {
        return view('public.tags.create', ['tag' => new Tag()]);
    }

    public function store(TagRequest $request): JsonResponse|RedirectResponse
    {
        $tag = $this->tagService->create($request->validated());

        if ($request->wantsJson()) {
            return response()->json([
                'message' => trans('messages.tag.created'),
                'tag' => $tag,
            ], 201);
        }

        return redirect()->route('tags.show', $tag)->with('status', trans('messages.tag.created'));
    }

    public function show(Request $request, int $tag): JsonResponse|View
    {
        $tagModel = $this->tagService->find($tag);

        if ($request->wantsJson()) {
            return response()->json($tagModel);
        }

        return view('public.tags.show', ['tag' => $tagModel]);
    }

    public function edit(int $tag): View
    {
        return view('public.tags.edit', ['tag' => $this->tagService->find($tag)]);
    }

    public function update(TagRequest $request, int $tag): JsonResponse|RedirectResponse
    {
        $tagModel = $this->tagService->find($tag);
        $tagModel = $this->tagService->update($tagModel, $request->validated());

        if ($request->wantsJson()) {
            return response()->json([
                'message' => trans('messages.tag.updated'),
                'tag' => $tagModel,
            ]);
        }

        return redirect()->route('tags.show', $tagModel)->with('status', trans('messages.tag.updated'));
    }

    public function destroy(Request $request, int $tag): JsonResponse|RedirectResponse
    {
        $tagModel = $this->tagService->find($tag);
        $this->tagService->delete($tagModel);

        if ($request->wantsJson()) {
            return response()->json(['message' => trans('messages.tag.deleted')]);
        }

        return redirect()->route('tags.index')->with('status', trans('messages.tag.deleted'));
    }
}
