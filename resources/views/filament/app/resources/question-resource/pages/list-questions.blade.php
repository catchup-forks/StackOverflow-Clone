@extends('public.master')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="heading-primary">@lang('Top Questions')</h1>
        <a href="{{ route('question.create') }}" class="cta-button">@lang('Ask Question')</a>
    </div>

    @include('public.tables.questions', ['questions' => $questions])
@endsection

@section('side-menu')
    @include('public.side-menus.questions', ['tags' => $tags])
@endsection
