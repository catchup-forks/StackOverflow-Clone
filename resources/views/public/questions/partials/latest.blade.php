<div class="space-y-6">
    <h2 class="text-2xl font-semibold text-slate-800">Latest Questions</h2>
    <div class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <tbody class="divide-y divide-slate-100 bg-white">
            @foreach($questions as $q)
                <tr class="transition hover:bg-slate-50/80">
                    <td class="p-4 text-center text-sm font-semibold text-slate-600">
                        <p>{{ $q->votes->count() }}</p>
                        <p class="text-xs uppercase tracking-wide text-slate-400">Vote</p>
                    </td>
                    <td class="p-4 text-center text-sm font-semibold text-slate-600">
                        <p>{{ $q->answer_count }}</p>
                        <p class="text-xs uppercase tracking-wide text-slate-400">Answers</p>
                    </td>
                    <td class="p-4 text-center text-sm font-semibold text-slate-600">
                        <p>{{ $q->view_count }}</p>
                        <p class="text-xs uppercase tracking-wide text-slate-400">Views</p>
                    </td>
                    <td class="p-4 text-sm text-slate-700">
                        <a href="/question/{{ $q->id }}" class="font-semibold text-emerald-600 hover:text-emerald-500">{{ $q->title }}</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div>
        {{ $questions->appends(request()->all())->links() }}
    </div>
</div>
