<div class="flex flex-wrap gap-2">
    @foreach($post->postTags as $tag)
        <a href="/tag/{{ $tag->name }}" class="tag-pill">
            {{ $tag->name }}
        </a>
    @endforeach
</div>
