<div class="space-y-6">
    <h2 class="heading-primary">Latest Questions</h2>
    <div class="overflow-hidden">
        <table class="table-nord">
            <tbody>
            @foreach($questions as $q)
                <tr class="transition-colors duration-200 hover:bg-[var(--color-surface-alt)] dark:hover:bg-[var(--color-surface-alt)]">
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
                        <a href="/question/{{ $q->id }}" class="font-semibold">{{ $q->title }}</a>
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
