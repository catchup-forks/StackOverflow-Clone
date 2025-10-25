@foreach($answers as $a)
    <div class="card space-y-4 transition-colors duration-300">
        <div class="flex items-start gap-6">
            <div class="vote-stack">
                <button type="button" class="vote-stack__button">▲</button>
                <p class="vote-stack__score">{{ $a->votes->count() }}</p>
                <button type="button" class="vote-stack__button">▼</button>
            </div>
            <div class="space-y-4 text-base leading-relaxed">
                <p>{{ $a->body }}</p>
            </div>
        </div>
    </div>
@endforeach
