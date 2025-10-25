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

    public function show(Request $request, Tag $tag): JsonResponse|View
    {
        if ($request->wantsJson()) {
            return response()->json($tag);
        }

        return view('public.tags.show', ['tag' => $tag]);
    }

    public function edit(Tag $tag): View
    {
        return view('public.tags.edit', ['tag' => $tag]);
    }

    public function update(TagRequest $request, Tag $tag): JsonResponse|RedirectResponse
    {
        $tag = $this->tagService->update($tag, $request->validated());

        if ($request->wantsJson()) {
            return response()->json([
                'message' => trans('messages.tag.updated'),
                'tag' => $tag,
            ]);
        }

        return redirect()->route('tags.show', $tag)->with('status', trans('messages.tag.updated'));
    }

    public function destroy(Request $request, Tag $tag): JsonResponse|RedirectResponse
    {
        $this->tagService->delete($tag);

        if ($request->wantsJson()) {
            return response()->json(['message' => trans('messages.tag.deleted')]);
        }

        return redirect()->route('tags.index')->with('status', trans('messages.tag.deleted'));
    }
}
