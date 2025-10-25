@extends('public.master')

@section('content')
    <header class="space-y-2">
        <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">Edit Tag</p>
        <h1 class="text-2xl font-semibold text-slate-900">Update “{{ $tag->name }}”</h1>
        <p class="text-sm text-slate-500">Adjust usage counts and metadata to keep this tag relevant.</p>
    </header>

    <form action="{{ route('tags.update', ['tag' => $tag->id]) }}" method="POST" class="mt-8 space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-2">
            <label for="name" class="text-sm font-semibold text-slate-700">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name', $tag->name) }}" required class="w-full rounded-2xl border border-slate-300 bg-white p-4 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" />
        </div>

        <div class="grid gap-6 sm:grid-cols-3">
            <div class="space-y-2">
                <label for="count" class="text-sm font-semibold text-slate-700">Usage count</label>
                <input id="count" name="count" type="number" min="0" value="{{ old('count', $tag->count) }}" class="w-full rounded-2xl border border-slate-300 bg-white p-3 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" />
            </div>
            <div class="space-y-2">
                <label for="excerpt_post_id" class="text-sm font-semibold text-slate-700">Excerpt post ID</label>
                <input id="excerpt_post_id" name="excerpt_post_id" type="number" min="0" value="{{ old('excerpt_post_id', $tag->excerpt_post_id) }}" class="w-full rounded-2xl border border-slate-300 bg-white p-3 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" />
            </div>
            <div class="space-y-2">
                <label for="wiki_post_id" class="text-sm font-semibold text-slate-700">Wiki post ID</label>
                <input id="wiki_post_id" name="wiki_post_id" type="number" min="0" value="{{ old('wiki_post_id', $tag->wiki_post_id) }}" class="w-full rounded-2xl border border-slate-300 bg-white p-3 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" />
            </div>
        </div>

        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('tags.show', ['tag' => $tag->id]) }}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600">Cancel</a>
            <button type="submit" class="rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-emerald-400">Save changes</button>
        </div>
    </form>
@endsection

@section('side-menu')
    <div class="space-y-4 text-sm text-slate-600">
        <h2 class="text-lg font-semibold text-slate-800">Why edit tags?</h2>
        <p>Keeping counts and references updated helps moderation tools stay accurate and keeps search results relevant.</p>
        <form action="{{ route('tags.destroy', ['tag' => $tag->id]) }}" method="POST" class="mt-4 space-y-2">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full rounded-full border border-rose-500 px-4 py-2 text-sm font-semibold text-rose-600 transition hover:bg-rose-500 hover:text-white">Delete tag</button>
        </form>
    </div>
@endsection
