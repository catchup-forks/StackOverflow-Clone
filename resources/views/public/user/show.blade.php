@extends('public.master')

@section('content')
    <header class="space-y-2">
        <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">Profile</p>
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">{{ $user->display_name }}</h1>
                <p class="text-sm text-slate-500">Joined {{ optional($user->creation_date)->format('M j, Y') ?? $user->created_at->format('M j, Y') }}</p>
            </div>
            <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="rounded-full bg-emerald-500 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-400">Edit profile</a>
        </div>
    </header>

    <section class="mt-8 grid gap-6 lg:grid-cols-2">
        <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">About</h2>
            <dl class="mt-4 space-y-3 text-sm text-slate-600">
                <div>
                    <dt class="font-semibold text-slate-700">Email</dt>
                    <dd>{{ $user->email }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-700">Location</dt>
                    <dd>{{ optional($user->profile)->location ?? ($user->location ?: 'Not specified') }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-700">Website</dt>
                    <dd>
                        @php($website = optional($user->profile)->website_url ?? $user->website_url)
                        @if($website)
                            <a href="{{ $website }}" class="text-emerald-600 hover:text-emerald-500" target="_blank" rel="noopener">{{ $website }}</a>
                        @else
                            <span>Not provided</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="font-semibold text-slate-700">About</dt>
                    <dd>{{ optional($user->profile)->bio ?? ($user->about_me ?: 'This user has not written an introduction yet.') }}</dd>
                </div>
            </dl>
        </article>

        <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Stats</h2>
            <dl class="mt-4 grid gap-4 text-sm text-slate-600 sm:grid-cols-2">
                <div class="rounded-xl bg-slate-50 p-4 text-center shadow-sm">
                    <dt class="text-xs uppercase tracking-wide text-slate-500">Reputation</dt>
                    <dd class="mt-1 text-xl font-semibold text-slate-900">{{ $user->reputation }}</dd>
                </div>
                <div class="rounded-xl bg-slate-50 p-4 text-center shadow-sm">
                    <dt class="text-xs uppercase tracking-wide text-slate-500">Profile views</dt>
                    <dd class="mt-1 text-xl font-semibold text-slate-900">{{ $user->views }}</dd>
                </div>
                <div class="rounded-xl bg-slate-50 p-4 text-center shadow-sm">
                    <dt class="text-xs uppercase tracking-wide text-slate-500">Up votes</dt>
                    <dd class="mt-1 text-xl font-semibold text-slate-900">{{ $user->up_votes }}</dd>
                </div>
                <div class="rounded-xl bg-slate-50 p-4 text-center shadow-sm">
                    <dt class="text-xs uppercase tracking-wide text-slate-500">Down votes</dt>
                    <dd class="mt-1 text-xl font-semibold text-slate-900">{{ $user->down_votes }}</dd>
                </div>
            </dl>
        </article>
    </section>

    <section class="mt-8">
        <h2 class="text-lg font-semibold text-slate-900">Recent posts</h2>
        <div class="mt-4 space-y-4">
            @forelse($recentPosts as $post)
                <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <a href="{{ route('question.show', ['question' => $post->id]) }}" class="text-base font-semibold text-slate-900 hover:text-emerald-600">{{ $post->title ?: 'Answer #' . $post->id }}</a>
                        <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ optional($post->creation_date)->format('M j, Y') ?? $post->created_at->format('M j, Y') }}</span>
                    </div>
                    <p class="mt-2 text-sm text-slate-500">{{ \Illuminate\Support\Str::limit($post->body, 160) }}</p>
                </article>
            @empty
                <p class="rounded-2xl border border-slate-200 bg-white p-6 text-center text-sm text-slate-500">This user has not posted anything yet.</p>
            @endforelse
        </div>
    </section>
@endsection

@section('side-menu')
    <div class="space-y-4 text-sm text-slate-600">
        <h2 class="text-lg font-semibold text-slate-800">Account actions</h2>
        <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST" class="space-y-2">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full rounded-full border border-rose-500 px-4 py-2 text-sm font-semibold text-rose-600 transition hover:bg-rose-500 hover:text-white">Delete user</button>
        </form>
        <a href="{{ route('users.index') }}" class="block text-sm font-semibold text-slate-600 hover:text-emerald-600">Back to user list</a>
    </div>
@endsection
