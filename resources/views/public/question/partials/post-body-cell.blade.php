<div class="flex-1 space-y-6">
    <div class="space-y-4 text-slate-700">
        <p>{{ $post->body }}</p>
    </div>

    @include('public.question.partials.post-tags')
    @include('public.question.partials.post-actions')
    @include('public.question.partials.post-comments')
</div>
