<div class="space-y-4">
    @foreach($post->comments as $com)
        <div class="flex gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex w-16 flex-col items-center justify-center gap-2">
                <span class="text-lg font-semibold text-slate-700">{{ $com->score }}</span>
                <span class="text-sm text-slate-400">▲</span>
            </div>
            <p class="flex-1 text-sm text-slate-600">{{ $com->body }}</p>
        </div>
    @endforeach

    <div class="flex gap-4 text-sm font-semibold text-emerald-600">
        <a href="#" class="hover:text-emerald-500">add comment</a>
        <a href="#" class="hover:text-emerald-500">start bounty</a>
    </div>
</div>
