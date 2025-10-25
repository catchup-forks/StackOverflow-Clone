@extends('public.master')

@section('content')
    <header class="space-y-2">
        <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">Tag details</p>
        <h1 class="text-2xl font-semibold text-slate-900">{{ $tag->name }}</h1>
        <p class="text-sm text-slate-500">{{ $tag->count }} questions use this tag.</p>
    </header>

    <section class="mt-8 space-y-6">
        @forelse($questions as $question)
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <a href="{{ route('question.show', ['question' => $question->id]) }}" class="text-lg font-semibold text-slate-900 hover:text-emerald-600">{{ $question->title }}</a>
                        <p class="mt-2 text-sm text-slate-500">{{ \Illuminate\Support\Str::limit($question->body, 140) }}</p>
                    </div>
                    <div class="text-right text-sm text-slate-500">
                        <p class="font-semibold text-slate-700">{{ $question->user->display_name ?? 'Anonymous' }}</p>
                        <p>{{ optional($question->creation_date)->format('M j, Y') ?? $question->created_at->format('M j, Y') }}</p>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-4 text-xs font-semibold text-slate-500">
                    <span>{{ $question->view_count }} views</span>
                    <span>{{ $question->answer_count }} answers</span>
                    <span>{{ $question->score }} votes</span>
                </div>
            </article>
        @empty
            <p class="rounded-2xl border border-slate-200 bg-white p-6 text-center text-sm text-slate-500">No questions have been tagged with <span class="font-semibold text-slate-700">{{ $tag->name }}</span> yet.</p>
        @endforelse
    </section>

    <div class="mt-8">
        {{ $questions->links() }}
    </div>
@endsection

@section('side-menu')
    <div class="space-y-4 text-sm text-slate-600">
        <h2 class="text-lg font-semibold text-slate-800">Manage this tag</h2>
        <p>Keep the wiki and excerpt posts up to date so newcomers can quickly understand what this tag represents.</p>
        <div class="flex flex-col gap-2">
            <a href="{{ route('tags.edit', ['tag' => $tag->id]) }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-500">Edit metadata</a>
            <a href="{{ route('tags.index') }}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600">Back to all tags</a>
        </div>
    </div>
@endsection
