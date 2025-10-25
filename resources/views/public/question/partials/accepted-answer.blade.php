@if(!empty($answer))
    <div class="answer-accepted flex flex-col gap-4 rounded-2xl p-6">
        <div class="flex items-start gap-6">
            <div class="flex w-24 flex-col items-center gap-3">
                <span class="text-lg">▲</span>
                <span class="text-xl font-semibold">{{ $answer->votes->count() }}</span>
                <span class="text-lg">▼</span>
                <span class="text-lg">✔</span>
            </div>
            <div class="space-y-4">
                <p>{{ $answer->body }}</p>
            </div>
        </div>
    </div>
@endif
