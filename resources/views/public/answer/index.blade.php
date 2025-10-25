@extends('public.master')

@section('content')
    <div class="space-y-6">
        <h1 class="text-2xl font-semibold">{{ __('Answers') }}</h1>
        <div class="space-y-4">
            @foreach ($answers as $answer)
                <article class="rounded border border-slate-200 bg-white p-4 shadow-sm">
                    <p class="text-slate-700">{{ $answer->body }}</p>
                    <p class="text-sm text-slate-500">{{ __('By :name', ['name' => $answer->owner_display_name]) }}</p>
                </article>
            @endforeach
        </div>
        {{ $answers->links() }}
    </div>
@endsection
