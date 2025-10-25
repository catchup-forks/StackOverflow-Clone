@extends('public.master')

@section('content')
    <header class="space-y-2">
        <p class="eyebrow">Edit Answer</p>
        <h1 class="heading-primary">Update your response</h1>
        <p class="text-sm text-muted">Make improvements or fix mistakes before resubmitting.</p>
    </header>

    <form action="{{ route('answer.update', ['answer' => $answer->id]) }}" method="POST" class="mt-8 space-y-6">
        @csrf
        @method('PUT')
        <input type="hidden" name="question_id" value="{{ $answer->parent_id }}">

        <div class="space-y-2">
            <label for="answer" class="text-sm font-semibold">Answer</label>
            <textarea id="answer" name="body" required class="form-field form-field--area">{{ old('body', $answer->body) }}</textarea>
            <p class="text-xs text-muted">Be clear and share relevant references or examples when possible.</p>
        </div>

        <div class="flex items-center justify-between gap-4">
            <a href="{{ $question ? route('question.show', ['question' => $question->id]) : route('questions.index') }}" class="text-sm font-semibold link-muted">Cancel</a>
            <button type="submit" class="cta-button">Save changes</button>
        </div>
    </form>
@endsection

@section('side-menu')
    <div class="space-y-3 text-sm text-muted">
        <h2 class="heading-secondary">Helpful editing tips</h2>
        <ul class="list-disc space-y-2 pl-5">
            <li>Keep answers focused on solving the original question.</li>
            <li>Use code blocks and formatting to improve readability.</li>
            <li>Share why your solution works when updating your response.</li>
        </ul>
    </div>
@endsection
