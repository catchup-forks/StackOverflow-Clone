@extends('public.master')

@section('content')
    <header class="space-y-2">
        <p class="eyebrow">Edit Question</p>
        <h1 class="heading-primary">Improve “{{ $question->title }}”</h1>
        <p class="text-sm text-muted">Update the details to keep the question accurate and helpful.</p>
    </header>

    <form action="{{ route('question.update', ['question' => $question->id]) }}" method="POST" class="mt-8 space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-2">
            <label for="title" class="text-sm font-semibold">Title</label>
            <input id="title" name="title" type="text" value="{{ old('title', $question->title) }}" required class="form-field" />
        </div>

        <div class="space-y-2">
            <label for="body" class="text-sm font-semibold">Description</label>
            <textarea id="body" name="body" required class="form-field form-field--area">{{ old('body', $question->body) }}</textarea>
        </div>

        <div class="space-y-2">
            <label for="tags" class="text-sm font-semibold">Tags</label>
            <select id="tags" name="tags[]" multiple class="form-field h-40">
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" @selected(collect(old('tags', $selectedTags))->contains($tag->id))>{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>

        <label class="flex items-center gap-3 text-sm font-semibold">
            <input type="checkbox" name="is_blog" value="1" @checked(old('is_blog', $question->is_blog)) class="h-4 w-4 rounded border border-transparent">
            <span>Mark as documentation article</span>
        </label>

        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('question.show', ['question' => $question->id]) }}" class="text-sm font-semibold link-muted">Cancel</a>
            <button type="submit" class="cta-button">Save changes</button>
        </div>
    </form>
@endsection

@section('side-menu')
    <div class="space-y-4 text-sm text-muted">
        <h2 class="heading-secondary">Editing reminders</h2>
        <ul class="list-disc space-y-2 pl-5">
            <li>Keep the original intent of the question intact.</li>
            <li>Clarify language and improve formatting for readability.</li>
            <li>Update tags so experts can continue to find the topic.</li>
        </ul>
    </div>
@endsection
