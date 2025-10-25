<div class="space-y-4">
    <h2 class="heading-secondary">Tags</h2>
    <ul class="flex flex-wrap gap-2">
        @foreach($tags as $t)
            <li>
                <a href="/tag/{{ $t->id }}" class="tag-pill">
                    {{ $t->name }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
