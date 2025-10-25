<div class="space-y-4">
    @foreach($post->comments as $com)
        <div class="flex gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex w-16 flex-col items-center justify-center gap-2">
                <span class="text-lg font-semibold text-slate-700">{{ $com->score }}</span>
                <span class="text-sm text-slate-400">▲</span>
            </div>
            <div class="flex-1 space-y-2 text-sm text-slate-600">
                <p>{{ $com->body }}</p>
                <form action="{{ route('comments.flag', $com) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-xs font-semibold uppercase tracking-wide text-rose-600 hover:text-rose-500">flag for admin review</button>
                </form>
            </div>
        </div>
    @endforeach

    <div class="flex gap-4 text-sm font-semibold text-emerald-600">
        <a href="#" class="hover:text-emerald-500">add comment</a>
        <a href="#" class="hover:text-emerald-500">start bounty</a>
    </div>
</div>
