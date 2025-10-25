@extends('public.master')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="heading-primary">{{ trans('stackoverflow.user.questions.pages.list.title') }}</h1>
        <a href="{{ route('question.create') }}" class="cta-button">{{ trans('stackoverflow.user.questions.list.ask_question') }}</a>
    </div>

    @include('public.tables.questions', ['questions' => $questions])
@endsection

@section('side-menu')
    @include('public.side-menus.questions', ['tags' => $tags])
@endsection
