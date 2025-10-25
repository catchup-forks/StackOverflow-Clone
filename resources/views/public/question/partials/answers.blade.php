<div class="space-y-6">
    <h4 class="text-xl font-semibold text-slate-800">
        {{ $post->answer_count }} {{ $post->answer_count > 1 ? 'Answers' : 'Answer' }}
    </h4>

    @include('public.question.partials.accepted-answer')
    @include('public.question.partials.other-answers')
</div>
