<hr class="my-8" />
<h4 class="heading-secondary">Know someone who can answer? Share a <a class="underline decoration-2 underline-offset-4" href="#">link</a> to this question via <a class="underline decoration-2 underline-offset-4" href="#">email</a>, <a class="underline decoration-2 underline-offset-4" href="#">Google+</a>, <a class="underline decoration-2 underline-offset-4" href="#">Twitter</a>, or <a class="underline decoration-2 underline-offset-4" href="#">Facebook</a>.</h4>

<form action="{{ route('answer.store') }}" method="POST" class="mt-6 space-y-4">
    @csrf
    <input type="hidden" name="question_id" value="{{ $post->id }}">
    <div class="space-y-2">
        <label for="answer" class="text-sm font-semibold">Your Answer</label>
        <textarea id="answer" name="body" required class="form-field form-field--area">{{ old('body') }}</textarea>
    </div>
    <button type="submit" class="cta-button">Post your answer</button>
</form>
