@extends('public.master')

@section('content')
    <header class="space-y-2">
        <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">Edit Answer</p>
        <h1 class="text-2xl font-semibold text-slate-900">Update your response</h1>
        <p class="text-sm text-slate-500">Make improvements or fix mistakes before resubmitting.</p>
    </header>

    <form action="{{ route('answer.update', ['answer' => $answer->id]) }}" method="POST" class="mt-8 space-y-6">
        @csrf
        @method('PUT')
        <input type="hidden" name="question_id" value="{{ $answer->parent_id }}">

        <div class="space-y-2">
            <label for="answer" class="text-sm font-semibold text-slate-700">Answer</label>
            <textarea id="answer" name="body" required class="min-h-[220px] w-full rounded-2xl border border-slate-300 bg-white p-4 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('body', $answer->body) }}</textarea>
            <p class="text-xs text-slate-400">Be clear and share relevant references or examples when possible.</p>
        </div>

        <div class="flex items-center justify-between gap-4">
            <a href="{{ $question ? route('question.show', ['question' => $question->id]) : route('questions.index') }}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600">Cancel</a>
            <button type="submit" class="rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-emerald-400">Save changes</button>
        </div>
    </form>
@endsection

@section('side-menu')
    <div class="space-y-3 text-sm text-slate-600">
        <h2 class="text-lg font-semibold text-slate-800">Helpful editing tips</h2>
        <ul class="list-disc space-y-2 pl-5">
            <li>Keep answers focused on solving the original question.</li>
            <li>Use code blocks and formatting to improve readability.</li>
            <li>Share why your solution works when updating your response.</li>
        </ul>
    </div>
@endsection
