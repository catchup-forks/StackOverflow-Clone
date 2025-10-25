<div class="space-y-6">
    <h2 class="heading-primary">{{ ucfirst(request('sort', 'latest')) }} Questions</h2>
    <div class="overflow-hidden">
        <table class="table-nord">
            <tbody>
            @foreach($questions as $q)
                <tr>
                    <td class="text-center text-sm font-semibold text-muted">
                        <p>{{ $q->votes->count() }}</p>
                        <p class="text-xs uppercase tracking-wide text-muted">Vote</p>
                    </td>
                    <td class="text-center text-sm font-semibold text-muted">
                        <p>{{ $q->answer_count }}</p>
                        <p class="text-xs uppercase tracking-wide text-muted">Answers</p>
                    </td>
                    <td class="text-center text-sm font-semibold text-muted">
                        <p>{{ $q->view_count }}</p>
                        <p class="text-xs uppercase tracking-wide text-muted">Views</p>
                    </td>
                    <td class="text-sm">
                        <p class="font-semibold">
                            <a href="{{ route('question.show', ['question' => $q->id]) }}">{{ $q->title }}</a>
                        </p>
                        <p class="mt-2 flex flex-wrap items-center gap-3 text-xs text-muted">
                            @foreach(explode(',', (string) $q->tags) as $tag)
                                <span class="tag-pill">{{ trim($tag) }}</span>
                            @endforeach
                            <span class="ml-auto font-semibold">{{ $q->user->reputation }}</span>
                            <a class="font-semibold" href="{{ route('users.show', ['user' => $q->user_id]) }}">{{ $q->user->display_name }}</a>
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
