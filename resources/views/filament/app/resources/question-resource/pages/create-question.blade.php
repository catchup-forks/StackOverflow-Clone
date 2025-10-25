@extends('public.master')

@section('content')
    <header class="space-y-2">
        <p class="eyebrow">{{ trans('stackoverflow.user.questions.pages.create.eyebrow') }}</p>
        <h1 class="heading-primary">{{ trans('stackoverflow.user.questions.pages.create.title') }}</h1>
        <p class="text-sm text-muted">{{ trans('stackoverflow.user.questions.pages.create.intro') }}</p>
    </header>

    <div class="mt-8 space-y-6">
        {{$this->form}}
        <x-filament-panels::form.actions :actions="$this->getFormActions()" />
    </div>
@endsection

@section('side-menu')
    <div class="space-y-4 text-sm text-muted">
        <h2 class="heading-secondary">{{ trans('stackoverflow.user.questions.pages.create.sidebar.title') }}</h2>
        <ul class="list-disc space-y-2 pl-5">
            <li>{{ trans('stackoverflow.user.questions.pages.create.sidebar.tips.summary') }}</li>
            <li>{{ trans('stackoverflow.user.questions.pages.create.sidebar.tips.results') }}</li>
            <li>{{ trans('stackoverflow.user.questions.pages.create.sidebar.tips.tagging') }}</li>
        </ul>
    </div>
@endsection
