<div class="space-y-4">
    <h2 class="text-lg font-semibold text-slate-800">Tags</h2>
    <ul class="space-y-2">
        @foreach($tags as $t)
            <li>
                <a href="/tag/{{ $t->id }}" class="inline-flex items-center rounded-full bg-slate-200 px-3 py-1 text-xs font-medium text-slate-700 hover:bg-slate-300">
                    {{ $t->name }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
