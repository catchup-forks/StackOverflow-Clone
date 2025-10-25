@extends('public.master')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-slate-900">@lang('Top Questions')</h1>
        <a href="{{ route('question.create') }}" class="rounded-full bg-emerald-500 px-5 py-2 text-sm font-semibold text-white shadow-lg transition hover:bg-emerald-400">@lang('Ask Question')</a>
    </div>

    @include('public.tables.questions', ['questions' => $questions])
@endsection

@section('side-menu')
    @include('public.side-menus.questions', ['tags' => $tags])
@endsection
