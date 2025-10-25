<div class="space-y-6">
    <h4 class="heading-secondary">
        {{ $post->answer_count }} {{ $post->answer_count > 1 ? 'Answers' : 'Answer' }}
    </h4>

    @include('public.question.partials.accepted-answer')
    @include('public.question.partials.other-answers')
</div>
