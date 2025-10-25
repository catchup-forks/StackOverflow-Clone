@extends('public.master')

@section('content')
    <div class="space-y-6">
        <h1 class="heading-primary">{{ trans('stackoverflow.answers.title') }}</h1>
        <div class="space-y-4">
            @foreach ($answers as $answer)
                <article class="card space-y-3 transition-colors duration-300">
                    <p>{{ $answer->body }}</p>
                    <p class="text-sm text-muted">{{ trans('stackoverflow.answers.by_name', ['name' => $answer->owner_display_name]) }}</p>
                </article>
            @endforeach
        </div>
        <div>
            {{ $answers->links() }}
        </div>
    </div>
@endsection
