@extends('public.master')

@section('content')
    <header class="space-y-2">
        <p class="eyebrow">Tag details</p>
        <h1 class="heading-primary">{{ $tag->name }}</h1>
        <p class="text-sm text-muted">{{ $tag->count }} questions use this tag.</p>
    </header>

    <section class="mt-8 space-y-6">
        @forelse($questions as $question)
            <article class="card space-y-4 transition-colors duration-300 p-5">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <a href="{{ route('question.show', ['question' => $question->id]) }}" class="text-lg font-semibold">{{ $question->title }}</a>
                        <p class="mt-2 text-sm text-muted">{{ \Illuminate\Support\Str::limit($question->body, 140) }}</p>
                    </div>
                    <div class="text-right text-sm text-muted">
                        <p class="font-semibold text-[var(--color-text)]">{{ $question->user->display_name ?? 'Anonymous' }}</p>
                        <p>{{ optional($question->creation_date)->format('M j, Y') ?? $question->created_at->format('M j, Y') }}</p>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-4 text-xs font-semibold text-muted">
                    <span>{{ $question->view_count }} views</span>
                    <span>{{ $question->answer_count }} answers</span>
                    <span>{{ $question->score }} votes</span>
                </div>
            </article>
        @empty
            <p class="card text-center text-sm text-muted">No questions have been tagged with <span class="font-semibold text-[var(--color-text)]">{{ $tag->name }}</span> yet.</p>
        @endforelse
    </section>

    <div class="mt-8">
        {{ $questions->links() }}
    </div>
@endsection

@section('side-menu')
    <div class="space-y-4 text-sm text-muted">
        <h2 class="heading-secondary">Manage this tag</h2>
        <p>Keep the wiki and excerpt posts up to date so newcomers can quickly understand what this tag represents.</p>
        <div class="flex flex-col gap-2">
            <a href="{{ route('tags.edit', ['tag' => $tag->id]) }}" class="text-sm font-semibold">Edit metadata</a>
            <a href="{{ route('tags.index') }}" class="text-sm font-semibold">Back to all tags</a>
        </div>
    </div>
@endsection
