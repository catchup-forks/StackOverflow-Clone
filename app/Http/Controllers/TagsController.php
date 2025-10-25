<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TagsController extends BaseController
{
    public function index(Request $request): Response
    {
        $query = Tag::query();

        if ($term = $request->get('q')) {
            $query->where('name', 'like', '%' . $term . '%');
        }

        $tags = $query->orderBy('name')->paginate(24)->withQueryString();

        return response()->view('public.tags.index', [
            'tags' => $tags,
            'search' => $request->get('q'),
        ]);
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('tag.create');
    }

    public function store(Request $request)
    {
        return app(TagController::class)->store($request);
    }

    public function show(int $id): Response
    {
        $tag = Tag::findOrFail($id);

        $questions = Post::where('post_type_id', 1)
            ->where('tags', 'like', '%' . $tag->name . '%')
            ->with(['user'])
            ->orderByDesc('creation_date')
            ->paginate(10)
            ->withQueryString();

        return response()->view('public.tags.show', [
            'tag' => $tag,
            'questions' => $questions,
        ]);
    }

    public function edit(int $id): RedirectResponse
    {
        return redirect()->route('tag.edit', ['tag' => $id]);
    }

    public function update(Request $request, int $id)
    {
        return app(TagController::class)->update($request, $id);
    }

    public function destroy(Request $request, int $id)
    {
        return app(TagController::class)->destroy($request, $id);
    }
}
