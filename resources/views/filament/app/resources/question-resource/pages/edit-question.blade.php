@extends('public.master')

@section('content')
    <header class="space-y-2">
        <p class="eyebrow">@lang('Edit Question')</p>
        <h1 class="heading-primary">
            @lang('Improve “:title”', ['title' => $this->record->title])
        </h1>
        <p class="text-sm text-muted">@lang('Update the details to keep the question accurate and helpful.')</p>
    </header>

    <div class="mt-8 space-y-6">
        {{ $this->form }}
        <x-filament-panels::form.actions :actions="$this->getFormActions()" />
    </div>
@endsection

@section('side-menu')
    <div class="space-y-4 text-sm text-muted">
        <h2 class="heading-secondary">@lang('Editing reminders')</h2>
        <ul class="list-disc space-y-2 pl-5">
            <li>@lang('Keep the original intent of the question intact.')</li>
            <li>@lang('Clarify language and improve formatting for readability.')</li>
            <li>@lang('Update tags so experts can continue to find the topic.')</li>
        </ul>
    </div>
@endsection
