@extends('public.master')

@section('content')
    <header class="space-y-2">
        <p class="eyebrow">Edit Profile</p>
        <h1 class="heading-primary">Update {{ $user->display_name }}</h1>
        <p class="text-sm text-muted">Keep the user’s details current for accurate moderation.</p>
    </header>

    <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST" class="mt-8 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid gap-6 sm:grid-cols-2">
            <div class="space-y-2">
                <label for="display_name" class="text-sm font-semibold">Display name</label>
                <input id="display_name" name="display_name" type="text" value="{{ old('display_name', $user->display_name) }}" required class="form-field" />
            </div>
            <div class="space-y-2">
                <label for="email" class="text-sm font-semibold">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="form-field" />
            </div>
        </div>

        <div class="grid gap-6 sm:grid-cols-4">
            <div class="space-y-2">
                <label for="age" class="text-sm font-semibold">Age</label>
                <input id="age" name="age" type="number" min="0" value="{{ old('age', $user->age) }}" class="form-field" />
            </div>
            <div class="space-y-2">
                <label for="reputation" class="text-sm font-semibold">Reputation</label>
                <input id="reputation" name="reputation" type="number" min="0" value="{{ old('reputation', $user->reputation) }}" class="form-field" />
            </div>
            <div class="space-y-2">
                <label for="up_votes" class="text-sm font-semibold">Up votes</label>
                <input id="up_votes" name="up_votes" type="number" min="0" value="{{ old('up_votes', $user->up_votes) }}" class="form-field" />
            </div>
            <div class="space-y-2">
                <label for="down_votes" class="text-sm font-semibold">Down votes</label>
                <input id="down_votes" name="down_votes" type="number" min="0" value="{{ old('down_votes', $user->down_votes) }}" class="form-field" />
            </div>
        </div>

        <div class="space-y-2">
            <label for="views" class="text-sm font-semibold">Profile views</label>
            <input id="views" name="views" type="number" min="0" value="{{ old('views', $user->views) }}" class="form-field" />
        </div>

        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('users.show', ['user' => $user->id]) }}" class="text-sm font-semibold link-muted">Cancel</a>
            <button type="submit" class="cta-button">Save changes</button>
        </div>
    </form>

    <section class="mt-12 space-y-6">
        <h2 class="heading-secondary">Profile details</h2>
        <form action="{{ route('users.profile', ['user' => $user->id]) }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid gap-6 sm:grid-cols-2">
                <div class="space-y-2">
                    <label for="profile_location" class="text-sm font-semibold">Location</label>
                    <input id="profile_location" name="location" type="text" value="{{ old('location', optional($user->profile)->location ?? $user->location) }}" class="form-field" />
                </div>
                <div class="space-y-2">
                    <label for="profile_website" class="text-sm font-semibold">Website</label>
                    <input id="profile_website" name="website_url" type="url" value="{{ old('website_url', optional($user->profile)->website_url ?? $user->website_url) }}" class="form-field" />
                </div>
            </div>

            <div class="space-y-2">
                <label for="profile_bio" class="text-sm font-semibold">Bio</label>
                <textarea id="profile_bio" name="bio" class="form-field form-field--area min-h-[140px]">{{ old('bio', optional($user->profile)->bio ?? $user->about_me) }}</textarea>
            </div>

            <div class="flex items-center justify-between gap-4">
                <span class="text-sm text-muted">Keep biographies concise and professional.</span>
                <button type="submit" class="cta-button">Update profile</button>
            </div>
        </form>
    </section>

    <section class="mt-12 space-y-6">
        <h2 class="heading-secondary">Change password</h2>
        <form action="{{ route('users.password', ['user' => $user->id]) }}" method="POST" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <label for="current_password" class="text-sm font-semibold">Current password</label>
                <input id="current_password" name="current_password" type="password" required class="form-field" />
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div class="space-y-2">
                    <label for="password" class="text-sm font-semibold">New password</label>
                    <input id="password" name="password" type="password" required class="form-field" />
                </div>
                <div class="space-y-2">
                    <label for="password_confirmation" class="text-sm font-semibold">Confirm password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required class="form-field" />
                </div>
            </div>

            <div class="flex items-center justify-between gap-4">
                <span class="text-sm text-muted">Use at least eight characters with a mix of letters and numbers.</span>
                <button type="submit" class="cta-button">Update password</button>
            </div>
        </form>
    </section>
@endsection

@section('side-menu')
    <div class="space-y-4 text-sm text-muted">
        <h2 class="heading-secondary">Profile maintenance</h2>
        <ul class="list-disc space-y-2 pl-5">
            <li>Verify changes with the user where possible.</li>
            <li>Large reputation adjustments should be documented.</li>
            <li>Encourage users to add a bio and links.</li>
        </ul>
    </div>
@endsection
