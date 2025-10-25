@php use Carbon\Carbon; @endphp
<div class="grid gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600 md:grid-cols-4">
    <div class="flex items-center gap-3">
        <a class="font-semibold text-emerald-600 hover:text-emerald-500" href="/question/{{ $post->id }}/share">share</a>
        <span class="text-slate-400">|</span>
        <a class="font-semibold text-emerald-600 hover:text-emerald-500" href="/question/{{ $post->id }}/edit">edit</a>
        <span class="text-slate-400">|</span>
        <a class="font-semibold text-emerald-600 hover:text-emerald-500" href="/question/{{ $post->id }}/flag">flag</a>
    </div>
    <div></div>
    <div>
        @if($post->last_editor_user_id != "")
            <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-slate-900/5">
                <p class="text-xs uppercase tracking-wide text-slate-400">Last edited by</p>
                <a href="/user/{{ $post->user_id }}" class="font-semibold text-emerald-600 hover:text-emerald-500">
                    {{ $post->owner_display_name }}
                </a>
                <p class="text-xs text-slate-500">{{ $post->user->reputation }} reputation</p>
            </div>
        @endif
    </div>
    <div>
        @php $askedDate = Carbon::instance($post->created_at); @endphp
        <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-slate-900/5">
            <p class="text-xs uppercase tracking-wide text-slate-400">Asked</p>
            <p class="text-sm font-medium text-slate-700">{{ $askedDate->toFormattedDateString() }}</p>
            <a href="/user/{{ $post->user_id }}" class="font-semibold text-emerald-600 hover:text-emerald-500">
                {{ $post->owner_display_name }}
            </a>
            <p class="text-xs text-slate-500">{{ $post->user->reputation }} reputation</p>
        </div>
    </div>
</div>
