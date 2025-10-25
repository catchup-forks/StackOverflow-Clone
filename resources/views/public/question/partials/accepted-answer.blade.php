@if(!empty($answer))
    <div class="flex flex-col gap-4 rounded-2xl border border-emerald-200 bg-emerald-50 p-6 shadow-sm">
        <div class="flex items-start gap-6">
            <div class="flex w-24 flex-col items-center gap-3">
                <span class="text-emerald-600">▲</span>
                <span class="text-xl font-semibold text-emerald-700">{{ $answer->votes->count() }}</span>
                <span class="text-emerald-600">▼</span>
                <span class="text-emerald-600">✔</span>
            </div>
            <div class="space-y-4 text-slate-700">
                <p>{{ $answer->body }}</p>
            </div>
        </div>
    </div>
@endif
