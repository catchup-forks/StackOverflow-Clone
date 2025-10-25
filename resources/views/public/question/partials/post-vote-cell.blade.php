<div class="flex w-24 flex-col items-center gap-3 rounded-2xl bg-slate-100 p-4 text-slate-500">
    <button type="button" class="text-2xl font-bold text-emerald-600">▲</button>
    <p class="text-xl font-semibold text-slate-800">{{ $post->votes->count() }}</p>
    <button type="button" class="text-2xl font-bold text-emerald-600">▼</button>
    <button type="button" class="text-2xl text-amber-500">☆</button>
</div>
