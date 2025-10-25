@extends('public.master')

@section('content')
    <header class="space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="eyebrow">Community</p>
                <h1 class="heading-primary">All users</h1>
                <p class="text-sm text-muted">Discover top contributors and new members.</p>
            </div>
            <a href="{{ route('users.create') }}" class="cta-button">Invite user</a>
        </div>

        <form action="{{ route('users.index') }}" method="GET" class="flex items-center gap-3">
            <input type="search" name="q" value="{{ $search }}" placeholder="Search by display name" class="form-field" />
            <button type="submit" class="cta-button cta-button--outline">Search</button>
        </form>
    </header>

    <section class="mt-8">
        <table class="table-nord">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Reputation</th>
                    <th>Votes</th>
                    <th>Views</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="flex flex-col">
                                <span class="font-semibold">{{ $user->display_name }}</span>
                                <span class="text-xs text-muted">{{ $user->email }}</span>
                            </div>
                        </td>
                        <td class="font-semibold">{{ $user->reputation }}</td>
                        <td>{{ $user->up_votes }} / {{ $user->down_votes }}</td>
                        <td>{{ $user->views }}</td>
                        <td>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('users.show', ['user' => $user->id]) }}" class="text-sm font-semibold">View</a>
                                <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="text-sm font-semibold link-muted">Edit</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-sm text-muted">No users match your search yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    <div class="mt-8">
        {{ $users->appends(['q' => $search])->links() }}
    </div>
@endsection

@section('side-menu')
    <div class="space-y-4 text-sm text-muted">
        <h2 class="heading-secondary">Community health</h2>
        <p>Recognise high reputation members and encourage constructive participation.</p>
        <p class="text-xs text-muted">Invite new moderators or mentors from the top contributors list.</p>
    </div>
@endsection
