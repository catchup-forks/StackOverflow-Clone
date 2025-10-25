<h2 class="heading-secondary">Tags</h2>
<ul class="mt-4 flex flex-wrap gap-2">
    @foreach($tags as $t)
        <li>
            <a href="/tag/{{ $t->id }}" class="tag-pill">
                {{ $t->name }}
            </a>
        </li>
    @endforeach
</ul>
