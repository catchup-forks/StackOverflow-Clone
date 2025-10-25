<div class="space-y-6">
    <h2 class="text-2xl font-semibold text-slate-800">{{ ucfirst(request('sort', 'latest')) }} Questions</h2>
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
                        <p class="font-semibold text-slate-900">
                            <a href="{{ route('question.show', ['question' => $q->id]) }}" class="hover:text-emerald-600">{{ $q->title }}</a>
                        </p>
                        <p class="mt-2 flex flex-wrap items-center gap-3 text-xs text-slate-500">
                            @foreach(explode(',', (string) $q->tags) as $tag)
                                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-3 py-1 font-medium text-emerald-700">{{ trim($tag) }}</span>
                            @endforeach
                            <span class="ml-auto font-semibold text-slate-700">{{ $q->user->reputation }}</span>
                            <a class="font-semibold text-emerald-600 hover:text-emerald-500" href="{{ route('users.show', ['user' => $q->user_id]) }}">{{ $q->user->display_name }}</a>
                        </p>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div>
        {{ $questions->appends(['sort' => request('sort')])->links() }}
    </div>
</div>
