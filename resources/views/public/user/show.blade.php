@extends('public.master')

@section('content')
    <header class="space-y-2">
        <p class="eyebrow">Profile</p>
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="heading-primary">{{ $user->display_name }}</h1>
                <p class="text-sm text-muted">Joined {{ optional($user->creation_date)->format('M j, Y') ?? $user->created_at->format('M j, Y') }}</p>
            </div>
            <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="cta-button">Edit profile</a>
        </div>
    </header>

    <section class="mt-8 grid gap-6 lg:grid-cols-2">
        <article class="card">
            <h2 class="heading-secondary">About</h2>
            <dl class="mt-4 space-y-3 text-sm text-muted">
                <div>
                    <dt class="font-semibold">Email</dt>
                    <dd>{{ $user->email }}</dd>
                </div>
                <div>
                    <dt class="font-semibold">Location</dt>
                    <dd>{{ optional($user->profile)->location ?? ($user->location ?: 'Not specified') }}</dd>
                </div>
                <div>
                    <dt class="font-semibold">Website</dt>
                    <dd>
                        @php($website = optional($user->profile)->website_url ?? $user->website_url)
                        @if($website)
                            <a href="{{ $website }}" class="underline decoration-2 underline-offset-4" target="_blank" rel="noopener">{{ $website }}</a>
                        @else
                            <span>Not provided</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="font-semibold">About</dt>
                    <dd>{{ optional($user->profile)->bio ?? ($user->about_me ?: 'This user has not written an introduction yet.') }}</dd>
                </div>
            </dl>
        </article>

        <article class="card">
            <h2 class="heading-secondary">Stats</h2>
            <dl class="mt-4 grid gap-4 text-sm text-muted sm:grid-cols-2">
                <div class="card card-muted text-center">
                    <dt class="text-xs uppercase tracking-wide text-muted">Reputation</dt>
                    <dd class="mt-1 text-xl font-semibold">{{ $user->reputation }}</dd>
                </div>
                <div class="card card-muted text-center">
                    <dt class="text-xs uppercase tracking-wide text-muted">Profile views</dt>
                    <dd class="mt-1 text-xl font-semibold">{{ $user->views }}</dd>
                </div>
                <div class="card card-muted text-center">
                    <dt class="text-xs uppercase tracking-wide text-muted">Up votes</dt>
                    <dd class="mt-1 text-xl font-semibold">{{ $user->up_votes }}</dd>
                </div>
                <div class="card card-muted text-center">
                    <dt class="text-xs uppercase tracking-wide text-muted">Down votes</dt>
                    <dd class="mt-1 text-xl font-semibold">{{ $user->down_votes }}</dd>
                </div>
            </dl>
        </article>
    </section>

    <section class="mt-8">
        <h2 class="heading-secondary">Recent posts</h2>
        <div class="mt-4 space-y-4">
            @forelse($recentPosts as $post)
                <article class="card">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <a href="{{ route('question.show', ['question' => $post->id]) }}" class="text-base font-semibold">{{ $post->title ?: 'Answer #' . $post->id }}</a>
                        <span class="text-xs font-semibold uppercase tracking-wide text-muted">{{ optional($post->creation_date)->format('M j, Y') ?? $post->created_at->format('M j, Y') }}</span>
                    </div>
                    <p class="mt-2 text-sm text-muted">{{ \Illuminate\Support\Str::limit($post->body, 160) }}</p>
                </article>
            @empty
                <p class="card text-center text-sm text-muted">This user has not posted anything yet.</p>
            @endforelse
        </div>
    </section>
@endsection

@section('side-menu')
    <div class="space-y-4 text-sm text-muted">
        <h2 class="heading-secondary">Account actions</h2>
        <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST" class="space-y-2">
            @csrf
            @method('DELETE')
            <button type="submit" class="cta-button cta-button--outline cta-button--danger w-full">Delete user</button>
        </form>
        <a href="{{ route('users.index') }}" class="block text-sm font-semibold link-muted">Back to user list</a>
    </div>
@endsection
