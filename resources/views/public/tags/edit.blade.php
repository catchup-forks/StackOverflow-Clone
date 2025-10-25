@extends('public.master')

@section('content')
    <header class="space-y-2">
        <p class="eyebrow">Edit Tag</p>
        <h1 class="heading-primary">Update “{{ $tag->name }}”</h1>
        <p class="text-sm text-muted">Adjust usage counts and metadata to keep this tag relevant.</p>
    </header>

    <form action="{{ route('tags.update', ['tag' => $tag->id]) }}" method="POST" class="mt-8 space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-2">
            <label for="name" class="text-sm font-semibold">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name', $tag->name) }}" required class="form-field" />
        </div>

        <div class="grid gap-6 sm:grid-cols-3">
            <div class="space-y-2">
                <label for="count" class="text-sm font-semibold">Usage count</label>
                <input id="count" name="count" type="number" min="0" value="{{ old('count', $tag->count) }}" class="form-field" />
            </div>
            <div class="space-y-2">
                <label for="excerpt_post_id" class="text-sm font-semibold">Excerpt post ID</label>
                <input id="excerpt_post_id" name="excerpt_post_id" type="number" min="0" value="{{ old('excerpt_post_id', $tag->excerpt_post_id) }}" class="form-field" />
            </div>
            <div class="space-y-2">
                <label for="wiki_post_id" class="text-sm font-semibold">Wiki post ID</label>
                <input id="wiki_post_id" name="wiki_post_id" type="number" min="0" value="{{ old('wiki_post_id', $tag->wiki_post_id) }}" class="form-field" />
            </div>
        </div>

        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('tags.show', ['tag' => $tag->id]) }}" class="text-sm font-semibold link-muted">Cancel</a>
            <button type="submit" class="cta-button">Save changes</button>
        </div>
    </form>
@endsection

@section('side-menu')
    <div class="space-y-4 text-sm text-muted">
        <h2 class="heading-secondary">Why edit tags?</h2>
        <p>Keeping counts and references updated helps moderation tools stay accurate and keeps search results relevant.</p>
        <form action="{{ route('tags.destroy', ['tag' => $tag->id]) }}" method="POST" class="mt-4 space-y-2">
            @csrf
            @method('DELETE')
            <button type="submit" class="cta-button cta-button--outline cta-button--danger w-full">Delete tag</button>
        </form>
    </div>
@endsection
