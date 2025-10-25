@extends('public.master')

@section('content')
    <header class="space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">Browse Tags</p>
                <h1 class="text-2xl font-semibold text-slate-900">All topics</h1>
                <p class="text-sm text-slate-500">Follow the technologies and concepts you care about.</p>
            </div>
            <a href="{{ route('tag.create') }}" class="rounded-full bg-emerald-500 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-400">Create tag</a>
        </div>

        <form action="{{ route('tags.index') }}" method="GET" class="flex items-center gap-3">
            <input type="search" name="q" value="{{ $search }}" placeholder="Filter by tag name" class="w-full rounded-2xl border border-slate-300 bg-white p-3 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" />
            <button type="submit" class="rounded-2xl border border-emerald-500 px-5 py-3 text-sm font-semibold text-emerald-600 transition hover:bg-emerald-500 hover:text-white">Search</button>
        </form>
    </header>

    <section class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @forelse($tags as $tag)
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <h2 class="text-lg font-semibold text-slate-900">{{ $tag->name }}</h2>
                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">{{ $tag->count }} uses</span>
                </div>
                <p class="mt-3 text-sm text-slate-500">Excerpt post: {{ $tag->excerpt_post_id ?: 'N/A' }}</p>
                <p class="text-sm text-slate-500">Wiki post: {{ $tag->wiki_post_id ?: 'N/A' }}</p>
                <div class="mt-4 flex items-center gap-3">
                    <a href="{{ route('tags.show', ['tag' => $tag->id]) }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-500">View posts</a>
                    <a href="{{ route('tag.edit', ['tag' => $tag->id]) }}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600">Edit</a>
                </div>
            </article>
        @empty
            <p class="col-span-full rounded-2xl border border-slate-200 bg-white p-6 text-center text-sm text-slate-500">No tags match your search yet.</p>
        @endforelse
    </section>

    <div class="mt-8">
        {{ $tags->links() }}
    </div>
@endsection

@section('side-menu')
    <div class="space-y-4 text-sm text-slate-600">
        <h2 class="text-lg font-semibold text-slate-800">What are tags?</h2>
        <p>Tags group related questions so the right experts can help faster. Use descriptive names that reflect the underlying technology or concept.</p>
        <p class="text-xs text-slate-400">Need a new tag? Make sure it is broad enough to gather at least a handful of questions.</p>
    </div>
@endsection
