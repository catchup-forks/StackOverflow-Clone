@extends('public.master')

@section('content')
    <header class="space-y-2">
        <p class="eyebrow">Ask Question</p>
        <h1 class="heading-primary">Post a new programming question</h1>
        <p class="text-sm text-muted">Share all relevant details so the community can help quickly.</p>
    </header>

    <form action="{{ route('question.store') }}" method="POST" class="mt-8 space-y-6">
        @csrf

        <div class="space-y-2">
            <label for="title" class="text-sm font-semibold">Title</label>
            <input id="title" name="title" type="text" value="{{ old('title') }}" required class="form-field" placeholder="What's your programming question? Be specific." />
        </div>

        <div class="space-y-2">
            <label for="body" class="text-sm font-semibold">Description</label>
            <textarea id="body" name="body" required class="form-field form-field--area">{{ old('body') }}</textarea>
            <p class="text-xs text-muted">Include sample code, error messages, and what you have tried.</p>
        </div>

        <div class="space-y-2">
            <label for="tags" class="text-sm font-semibold">Tags</label>
            <select id="tags" name="tags[]" multiple class="form-field h-40">
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" @selected(collect(old('tags', $selectedTags))->contains($tag->id))>{{ $tag->name }}</option>
                @endforeach
            </select>
            <p class="text-xs text-muted">Hold <kbd>Ctrl</kbd> or <kbd>⌘</kbd> to select multiple tags.</p>
        </div>

        <label class="flex items-center gap-3 text-sm font-semibold">
            <input type="checkbox" name="is_blog" value="1" @checked(old('is_blog')) class="h-4 w-4 rounded border border-transparent">
            <span>Create as documentation article</span>
        </label>

        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('questions.index') }}" class="text-sm font-semibold link-muted">Cancel</a>
            <button type="submit" class="cta-button">Publish question</button>
        </div>
    </form>
@endsection

@section('side-menu')
    <div class="space-y-4 text-sm text-muted">
        <h2 class="heading-secondary">Writing great questions</h2>
        <ul class="list-disc space-y-2 pl-5">
            <li>Summarise the problem in a single sentence.</li>
            <li>Share the expected and actual results.</li>
            <li>Tag the question so experts can find it faster.</li>
        </ul>
    </div>
@endsection
