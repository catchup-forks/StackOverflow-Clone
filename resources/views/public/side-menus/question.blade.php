@php use Carbon\Carbon; @endphp
<h2 class="text-lg font-semibold text-slate-800">Question info</h2>
<ul class="mt-4 space-y-2 text-sm text-slate-600">
    <li>
        <p>
            <span class="font-semibold">Asked:</span>
            @php $asked = Carbon::instance($post->created_at); @endphp
            {{ $asked->diffForHumans(Carbon::now()) }}
        </p>
    </li>
    <li>
        <p>
            <span class="font-semibold">Views:</span> {{ $post->view_count }}
        </p>
    </li>
    <li>
        <p>
            <span class="font-semibold">Active:</span>
            @php $active = Carbon::instance($post->updated_at); @endphp
            {{ $active->diffForHumans(Carbon::now()) }}
        </p>
    </li>
</ul>

<h2 class="mt-8 text-lg font-semibold text-slate-800">Tags</h2>
<ul class="mt-4 space-y-2">
    @foreach($tags as $t)
        <li>
            <a href="/tag/{{ $t->id }}" class="inline-flex items-center rounded-full bg-slate-200 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-slate-300">
                {{ $t->name }}
            </a>
        </li>
    @endforeach
</ul>
