<h1 class="text-3xl font-bold text-slate-900">{{ $post->title }}</h1>
<hr class="my-6 border-slate-200" />
<div class="flex flex-col gap-6 lg:flex-row">
    <div class="flex flex-1 flex-col gap-6 lg:flex-row">
        @include('public.question.partials.post-vote-cell')
        @include('public.question.partials.post-body-cell')
    </div>
</div>
