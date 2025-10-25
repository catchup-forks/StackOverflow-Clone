@extends('public.master')

@section('content')
    <header class="space-y-2">
        <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">Create Tag</p>
        <h1 class="text-2xl font-semibold text-slate-900">Add a new tag</h1>
        <p class="text-sm text-slate-500">Define a clear, descriptive name so the community can find related questions.</p>
    </header>

    <form action="{{ route('tag.store') }}" method="POST" class="mt-8 space-y-6">
        @csrf

        <div class="space-y-2">
            <label for="name" class="text-sm font-semibold text-slate-700">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required class="w-full rounded-2xl border border-slate-300 bg-white p-4 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="e.g. laravel, tailwindcss" />
        </div>

        <div class="grid gap-6 sm:grid-cols-3">
            <div class="space-y-2">
                <label for="count" class="text-sm font-semibold text-slate-700">Usage count</label>
                <input id="count" name="count" type="number" min="0" value="{{ old('count') }}" class="w-full rounded-2xl border border-slate-300 bg-white p-3 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" />
            </div>
            <div class="space-y-2">
                <label for="excerpt_post_id" class="text-sm font-semibold text-slate-700">Excerpt post ID</label>
                <input id="excerpt_post_id" name="excerpt_post_id" type="number" min="0" value="{{ old('excerpt_post_id') }}" class="w-full rounded-2xl border border-slate-300 bg-white p-3 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" />
            </div>
            <div class="space-y-2">
                <label for="wiki_post_id" class="text-sm font-semibold text-slate-700">Wiki post ID</label>
                <input id="wiki_post_id" name="wiki_post_id" type="number" min="0" value="{{ old('wiki_post_id') }}" class="w-full rounded-2xl border border-slate-300 bg-white p-3 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" />
            </div>
        </div>

        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('tags.index') }}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600">Cancel</a>
            <button type="submit" class="rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-emerald-400">Create tag</button>
        </div>
    </form>
@endsection

@section('side-menu')
    <div class="space-y-4 text-sm text-slate-600">
        <h2 class="text-lg font-semibold text-slate-800">Tag naming tips</h2>
        <ul class="list-disc space-y-2 pl-5">
            <li>Use lowercase letters and hyphens for multi-word concepts.</li>
            <li>Prefer technology names over project-specific jargon.</li>
            <li>Ensure the tag will apply to multiple questions.</li>
        </ul>
    </div>
@endsection
