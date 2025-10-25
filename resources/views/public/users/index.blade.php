@extends('public.master')

@section('content')
    <header class="space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">Community</p>
                <h1 class="text-2xl font-semibold text-slate-900">All users</h1>
                <p class="text-sm text-slate-500">Discover top contributors and new members.</p>
            </div>
            <a href="{{ route('users.create') }}" class="rounded-full bg-emerald-500 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-400">Invite user</a>
        </div>

        <form action="{{ route('users.index') }}" method="GET" class="flex items-center gap-3">
            <input type="search" name="q" value="{{ $search }}" placeholder="Search by display name" class="w-full rounded-2xl border border-slate-300 bg-white p-3 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" />
            <button type="submit" class="rounded-2xl border border-emerald-500 px-5 py-3 text-sm font-semibold text-emerald-600 transition hover:bg-emerald-500 hover:text-white">Search</button>
        </form>
    </header>

    <section class="mt-8 overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Reputation</th>
                    <th class="px-4 py-3">Votes</th>
                    <th class="px-4 py-3">Views</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white text-sm text-slate-700">
                @forelse($users as $user)
                    <tr class="transition hover:bg-slate-50/80">
                        <td class="px-4 py-3">
                            <div class="flex flex-col">
                                <span class="font-semibold text-slate-900">{{ $user->display_name }}</span>
                                <span class="text-xs text-slate-500">{{ $user->email }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 font-semibold text-slate-900">{{ $user->reputation }}</td>
                        <td class="px-4 py-3">{{ $user->up_votes }} / {{ $user->down_votes }}</td>
                        <td class="px-4 py-3">{{ $user->views }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('users.show', ['user' => $user->id]) }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-500">View</a>
                                <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600">Edit</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500">No users match your search yet.</td>
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
    <div class="space-y-4 text-sm text-slate-600">
        <h2 class="text-lg font-semibold text-slate-800">Community health</h2>
        <p>Recognise high reputation members and encourage constructive participation.</p>
        <p class="text-xs text-slate-400">Invite new moderators or mentors from the top contributors list.</p>
    </div>
@endsection
