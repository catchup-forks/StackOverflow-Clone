@extends('public.master')

@section('content')
    <header class="space-y-2">
        <p class="eyebrow">@lang('Ask Question')</p>
        <h1 class="heading-primary">@lang('Post a new programming question')</h1>
        <p class="text-sm text-muted">@lang('Share all relevant details so the community can help quickly.')</p>
    </header>

    <div class="mt-8 space-y-6">
        {{ $this->form }}
        <x-filament-panels::form.actions :actions="$this->getFormActions()" />
    </div>
@endsection

@section('side-menu')
    <div class="space-y-4 text-sm text-muted">
        <h2 class="heading-secondary">@lang('Writing great questions')</h2>
        <ul class="list-disc space-y-2 pl-5">
            <li>@lang('Summarise the problem in a single sentence.')</li>
            <li>@lang('Share the expected and actual results.')</li>
            <li>@lang('Tag the question so experts can find it faster.')</li>
        </ul>
    </div>
@endsection
