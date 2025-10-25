<div class="space-y-4">
    @foreach($post->comments as $com)
        <div class="flex gap-4 rounded-2xl border border-[var(--color-border)] bg-[var(--color-surface)] p-4 text-sm transition-colors duration-300 shadow-sm dark:border-[var(--color-border)] dark:bg-[var(--color-surface)]">
            <div class="flex w-16 flex-col items-center justify-center gap-2 text-muted">
                <span class="text-lg font-semibold text-[var(--color-text)]">{{ $com->score }}</span>
                <span class="text-sm">▲</span>
            </div>
            <div class="flex-1 space-y-2 text-muted">
                <p>{{ $com->body }}</p>
                <form action="{{ route('comments.flag', $com) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-xs font-semibold uppercase tracking-wide text-danger transition-colors duration-200">flag for admin review</button>
                </form>
            </div>
        </div>
    @endforeach

    <div class="flex gap-4 text-sm font-semibold">
        <a href="#" class="transition-colors duration-200">add comment</a>
        <a href="#" class="transition-colors duration-200">start bounty</a>
    </div>
</div>
