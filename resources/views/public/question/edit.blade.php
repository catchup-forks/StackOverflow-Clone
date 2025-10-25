@extends('public.master')

@section('content')
    <header class="space-y-2">
        <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">Edit Question</p>
        <h1 class="text-2xl font-semibold text-slate-900">Improve “{{ $question->title }}”</h1>
        <p class="text-sm text-slate-500">Update the details to keep the question accurate and helpful.</p>
    </header>

    <form action="{{ route('question.update', ['question' => $question->id]) }}" method="POST" class="mt-8 space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-2">
            <label for="title" class="text-sm font-semibold text-slate-700">Title</label>
            <input id="title" name="title" type="text" value="{{ old('title', $question->title) }}" required class="w-full rounded-2xl border border-slate-300 bg-white p-4 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" />
        </div>

        <div class="space-y-2">
            <label for="body" class="text-sm font-semibold text-slate-700">Description</label>
            <textarea id="body" name="body" required class="min-h-[260px] w-full rounded-2xl border border-slate-300 bg-white p-4 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('body', $question->body) }}</textarea>
        </div>

        <div class="space-y-2">
            <label for="tags" class="text-sm font-semibold text-slate-700">Tags</label>
            <select id="tags" name="tags[]" multiple class="h-40 w-full rounded-2xl border border-slate-300 bg-white p-3 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" @selected(collect(old('tags', $selectedTags))->contains($tag->id))>{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>

        <label class="flex items-center gap-3 text-sm font-semibold text-slate-700">
            <input type="checkbox" name="is_blog" value="1" @checked(old('is_blog', $question->is_blog)) class="h-4 w-4 rounded border-slate-300 text-emerald-500 focus:ring-emerald-500">
            <span>Mark as documentation article</span>
        </label>

        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('question.show', ['question' => $question->id]) }}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600">Cancel</a>
            <button type="submit" class="rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-emerald-400">Save changes</button>
        </div>
    </form>
@endsection

@section('side-menu')
    <div class="space-y-4 text-sm text-slate-600">
        <h2 class="text-lg font-semibold text-slate-800">Editing reminders</h2>
        <ul class="list-disc space-y-2 pl-5">
            <li>Keep the original intent of the question intact.</li>
            <li>Clarify language and improve formatting for readability.</li>
            <li>Update tags so experts can continue to find the topic.</li>
        </ul>
    </div>
@endsection
