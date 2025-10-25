@extends('public.master')

@section('content')
    <header class="space-y-2">
        <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">Ask Question</p>
        <h1 class="text-2xl font-semibold text-slate-900">Post a new programming question</h1>
        <p class="text-sm text-slate-500">Share all relevant details so the community can help quickly.</p>
    </header>

    <form action="{{ route('question.store') }}" method="POST" class="mt-8 space-y-6">
        @csrf

        <div class="space-y-2">
            <label for="title" class="text-sm font-semibold text-slate-700">Title</label>
            <input id="title" name="title" type="text" value="{{ old('title') }}" required class="w-full rounded-2xl border border-slate-300 bg-white p-4 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="What's your programming question? Be specific." />
        </div>

        <div class="space-y-2">
            <label for="body" class="text-sm font-semibold text-slate-700">Description</label>
            <textarea id="body" name="body" required class="min-h-[260px] w-full rounded-2xl border border-slate-300 bg-white p-4 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('body') }}</textarea>
            <p class="text-xs text-slate-400">Include sample code, error messages, and what you have tried.</p>
        </div>

        <div class="space-y-2">
            <label for="tags" class="text-sm font-semibold text-slate-700">Tags</label>
            <select id="tags" name="tags[]" multiple class="h-40 w-full rounded-2xl border border-slate-300 bg-white p-3 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" @selected(collect(old('tags', $selectedTags))->contains($tag->id))>{{ $tag->name }}</option>
                @endforeach
            </select>
            <p class="text-xs text-slate-400">Hold <kbd class="rounded bg-slate-100 px-1 py-0.5 text-[10px] text-slate-500">Ctrl</kbd> or <kbd class="rounded bg-slate-100 px-1 py-0.5 text-[10px] text-slate-500">⌘</kbd> to select multiple tags.</p>
        </div>

        <label class="flex items-center gap-3 text-sm font-semibold text-slate-700">
            <input type="checkbox" name="is_blog" value="1" @checked(old('is_blog')) class="h-4 w-4 rounded border-slate-300 text-emerald-500 focus:ring-emerald-500">
            <span>Create as documentation article</span>
        </label>

        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('questions.index') }}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600">Cancel</a>
            <button type="submit" class="rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-emerald-400">Publish question</button>
        </div>
    </form>
@endsection

@section('side-menu')
    <div class="space-y-4 text-sm text-slate-600">
        <h2 class="text-lg font-semibold text-slate-800">Writing great questions</h2>
        <ul class="list-disc space-y-2 pl-5">
            <li>Summarise the problem in a single sentence.</li>
            <li>Share the expected and actual results.</li>
            <li>Tag the question so experts can find it faster.</li>
        </ul>
    </div>
@endsection
