<div class="flex flex-wrap gap-2">
    @foreach($post->postTags as $tag)
        <a href="/tag/{{ $tag->name }}" class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700">
            {{ $tag->name }}
        </a>
    @endforeach
</div>
