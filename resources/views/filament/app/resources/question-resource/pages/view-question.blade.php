@extends('public.master')

@section('content')
    @include('public.question.partials.post', ['post' => $post])
    <hr class="my-6 border-slate-200" />
    @include('public.question.partials.answers', ['post' => $post, 'answer' => $answer, 'answers' => $answers])
    @include('public.forms.answer', ['post' => $post])
@endsection

@section('side-menu')
    @include('public.side-menus.question', ['post' => $post, 'tags' => $tags])
@endsection
