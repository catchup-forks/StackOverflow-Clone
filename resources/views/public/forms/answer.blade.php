<hr class="my-8 border-slate-200" />
<h4 class="text-lg font-semibold text-slate-800">Know someone who can answer? Share a <a class="text-emerald-600 hover:text-emerald-500" href="#">link</a> to this question via <a class="text-emerald-600 hover:text-emerald-500" href="#">email</a>, <a class="text-emerald-600 hover:text-emerald-500" href="#">Google+</a>, <a class="text-emerald-600 hover:text-emerald-500" href="#">Twitter</a>, or <a class="text-emerald-600 hover:text-emerald-500" href="#">Facebook</a>.</h4>

<form action="{{ route('answer.store') }}" method="POST" class="mt-6 space-y-4">
    @csrf
    <input type="hidden" name="question_id" value="{{ $post->id }}">
    <div class="space-y-2">
        <label for="answer" class="text-sm font-semibold text-slate-700">Your Answer</label>
        <textarea id="answer" name="body" required class="min-h-[200px] w-full rounded-2xl border border-slate-300 bg-white p-4 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('body') }}</textarea>
    </div>
    <button type="submit" class="rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-emerald-400">Post your answer</button>
</form>
