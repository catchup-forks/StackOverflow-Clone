@php use Carbon\Carbon; @endphp
<h2 class="heading-secondary">Question info</h2>
<ul class="mt-4 space-y-2 text-sm text-muted">
    <li>
        <p>
            <span class="font-semibold text-[var(--color-text)]">Asked:</span>
            @php $asked = Carbon::instance($post->created_at); @endphp
            {{ $asked->diffForHumans(Carbon::now()) }}
        </p>
    </li>
    <li>
        <p>
            <span class="font-semibold text-[var(--color-text)]">Views:</span> {{ $post->view_count }}
        </p>
    </li>
    <li>
        <p>
            <span class="font-semibold text-[var(--color-text)]">Active:</span>
            @php $active = Carbon::instance($post->updated_at); @endphp
            {{ $active->diffForHumans(Carbon::now()) }}
        </p>
    </li>
</ul>

<h2 class="mt-8 heading-secondary">Tags</h2>
<ul class="mt-4 flex flex-wrap gap-2">
    @foreach($tags as $t)
        <li>
            <a href="/tag/{{ $t->id }}" class="tag-pill">
                {{ $t->name }}
            </a>
        </li>
    @endforeach
</ul>
