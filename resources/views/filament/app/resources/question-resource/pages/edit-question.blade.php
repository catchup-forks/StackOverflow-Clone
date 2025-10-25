@extends('public.master')

@section('content')
    <header class="space-y-2">
        <p class="eyebrow">{{ trans('stackoverflow.user.questions.pages.edit.eyebrow') }}</p>
        <h1 class="heading-primary">
            {{ trans('stackoverflow.user.questions.pages.edit.title', ['title' => $this->record->title]) }}
        </h1>
        <p class="text-sm text-muted">{{ trans('stackoverflow.user.questions.pages.edit.intro') }}</p>
    </header>

    <div class="mt-8 space-y-6">
        {{$this->form}}
        <x-filament-panels::form.actions :actions="$this->getFormActions()" />
    </div>
@endsection

@section('side-menu')
    <div class="space-y-4 text-sm text-muted">
        <h2 class="heading-secondary">{{ trans('stackoverflow.user.questions.pages.edit.sidebar.title') }}</h2>
        <ul class="list-disc space-y-2 pl-5">
            <li>{{ trans('stackoverflow.user.questions.pages.edit.sidebar.tips.intent') }}</li>
            <li>{{ trans('stackoverflow.user.questions.pages.edit.sidebar.tips.clarity') }}</li>
            <li>{{ trans('stackoverflow.user.questions.pages.edit.sidebar.tips.tags') }}</li>
        </ul>
    </div>
@endsection
