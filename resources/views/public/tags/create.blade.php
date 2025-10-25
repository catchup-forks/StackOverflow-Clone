@extends('public.master')

@section('content')
    <header class="space-y-2">
        <p class="eyebrow">Create Tag</p>
        <h1 class="heading-primary">Add a new tag</h1>
        <p class="text-sm text-muted">Define a clear, descriptive name so the community can find related questions.</p>
    </header>

    <form action="{{ route('tags.store') }}" method="POST" class="mt-8 space-y-6">
        @csrf

        <div class="space-y-2">
            <label for="name" class="text-sm font-semibold">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required class="form-field" placeholder="e.g. laravel, tailwindcss" />
        </div>

        <div class="grid gap-6 sm:grid-cols-3">
            <div class="space-y-2">
                <label for="count" class="text-sm font-semibold">Usage count</label>
                <input id="count" name="count" type="number" min="0" value="{{ old('count') }}" class="form-field" />
            </div>
            <div class="space-y-2">
                <label for="excerpt_post_id" class="text-sm font-semibold">Excerpt post ID</label>
                <input id="excerpt_post_id" name="excerpt_post_id" type="number" min="0" value="{{ old('excerpt_post_id') }}" class="form-field" />
            </div>
            <div class="space-y-2">
                <label for="wiki_post_id" class="text-sm font-semibold">Wiki post ID</label>
                <input id="wiki_post_id" name="wiki_post_id" type="number" min="0" value="{{ old('wiki_post_id') }}" class="form-field" />
            </div>
        </div>

        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('tags.index') }}" class="text-sm font-semibold link-muted">Cancel</a>
            <button type="submit" class="cta-button">Create tag</button>
        </div>
    </form>
@endsection

@section('side-menu')
    <div class="space-y-4 text-sm text-muted">
        <h2 class="heading-secondary">Tag naming tips</h2>
        <ul class="list-disc space-y-2 pl-5">
            <li>Use lowercase letters and hyphens for multi-word concepts.</li>
            <li>Prefer technology names over project-specific jargon.</li>
            <li>Ensure the tag will apply to multiple questions.</li>
        </ul>
    </div>
@endsection
