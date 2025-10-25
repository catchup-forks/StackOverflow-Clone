@extends('public.master')

@section('content')
    <header class="space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="eyebrow">Browse Tags</p>
                <h1 class="heading-primary">All topics</h1>
                <p class="text-sm text-muted">Follow the technologies and concepts you care about.</p>
            </div>
            <a href="{{ route('tags.create') }}" class="cta-button">Create tag</a>
        </div>

        <form action="{{ route('tags.index') }}" method="GET" class="flex items-center gap-3">
            <input type="search" name="q" value="{{ $search }}" placeholder="Filter by tag name" class="form-field" />
            <button type="submit" class="cta-button cta-button--outline">Search</button>
        </form>
    </header>

    <section class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @forelse($tags as $tag)
            <article class="card space-y-3">
                <div class="flex items-start justify-between">
                    <h2 class="heading-secondary">{{ $tag->name }}</h2>
                    <span class="tag-pill"><span class="tag-pill__icon">#</span>{{ $tag->count }} uses</span>
                </div>
                <p class="text-sm text-muted">Excerpt post: {{ $tag->excerpt_post_id ?: 'N/A' }}</p>
                <p class="text-sm text-muted">Wiki post: {{ $tag->wiki_post_id ?: 'N/A' }}</p>
                <div class="mt-4 flex items-center gap-3">
                    <a href="{{ route('tags.show', ['tag' => $tag->id]) }}" class="text-sm font-semibold">View posts</a>
                    <a href="{{ route('tags.edit', ['tag' => $tag->id]) }}" class="text-sm font-semibold link-muted">Edit</a>
                </div>
            </article>
        @empty
            <p class="col-span-full card text-center text-sm text-muted">No tags match your search yet.</p>
        @endforelse
    </section>

    <div class="mt-8">
        {{ $tags->links() }}
    </div>
@endsection

@section('side-menu')
    <div class="space-y-4 text-sm text-muted">
        <h2 class="heading-secondary">What are tags?</h2>
        <p>Tags group related questions so the right experts can help faster. Use descriptive names that reflect the underlying technology or concept.</p>
        <p class="text-xs text-muted">Need a new tag? Make sure it is broad enough to gather at least a handful of questions.</p>
    </div>
@endsection
