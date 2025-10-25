<h1 class="heading-primary">{{ $post->title }}</h1>
<hr class="my-6 border-0 border-t border-[var(--color-border)] transition-colors duration-300" />
<div class="flex flex-col gap-6 lg:flex-row">
    <div class="flex flex-1 flex-col gap-6 lg:flex-row">
        @include('public.question.partials.post-vote-cell')
        @include('public.question.partials.post-body-cell')
    </div>
</div>
