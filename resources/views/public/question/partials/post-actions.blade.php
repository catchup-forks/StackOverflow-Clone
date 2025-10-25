@php use Carbon\Carbon; @endphp
<div class="grid gap-4 rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface-alt)] p-4 text-sm text-muted transition-colors duration-300 md:grid-cols-4 dark:border-[var(--color-border)] dark:bg-[var(--color-surface-alt)]">
    <div class="flex items-center gap-3 text-sm">
        <a class="font-semibold" href="{{ route('question.show', ['question' => $post->id]) }}">share</a>
        <span class="text-muted">|</span>
        <a class="font-semibold" href="{{ route('question.edit', ['question' => $post->id]) }}">edit</a>
        <span class="text-muted">|</span>
        <a class="font-semibold" href="{{ route('question.show', ['question' => $post->id]) }}#flag">flag</a>
    </div>
    <div></div>
    <div>
        @if($post->last_editor_user_id != "")
            <div class="surface-section">
                <p class="text-xs uppercase tracking-wide text-muted">Last edited by</p>
                <a href="{{ route('users.show', ['user' => $post->user_id]) }}" class="font-semibold">
                    {{ $post->owner_display_name }}
                </a>
                <p class="text-xs text-muted">{{ $post->user->reputation }} reputation</p>
            </div>
        @endif
    </div>
    <div>
        @php $askedDate = Carbon::instance($post->created_at); @endphp
        <div class="surface-section">
            <p class="text-xs uppercase tracking-wide text-muted">Asked</p>
            <p class="text-sm font-medium text-[var(--color-text)]">{{ $askedDate->toFormattedDateString() }}</p>
            <a href="{{ route('users.show', ['user' => $post->user_id]) }}" class="font-semibold">
                {{ $post->owner_display_name }}
            </a>
            <p class="text-xs text-muted">{{ $post->user->reputation }} reputation</p>
        </div>
    </div>
</div>
