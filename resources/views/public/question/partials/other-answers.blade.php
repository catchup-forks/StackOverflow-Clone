@foreach($answers as $a)
    <div class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-start gap-6">
            <div class="flex w-24 flex-col items-center gap-3">
                <span class="text-slate-500">▲</span>
                <span class="text-xl font-semibold text-slate-700">{{ $a->votes->count() }}</span>
                <span class="text-slate-500">▼</span>
            </div>
            <div class="space-y-4 text-slate-700">
                <p>{{ $a->body }}</p>
            </div>
        </div>
    </div>
@endforeach
