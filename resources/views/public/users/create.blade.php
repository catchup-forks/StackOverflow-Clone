@extends('public.master')

@section('content')
    <header class="space-y-2">
        <p class="eyebrow">Invite User</p>
        <h1 class="heading-primary">Add a new community member</h1>
        <p class="text-sm text-muted">Capture key profile details to seed their account.</p>
    </header>

    <form action="{{ route('users.store') }}" method="POST" class="mt-8 space-y-6">
        @csrf

        <div class="grid gap-6 sm:grid-cols-2">
            <div class="space-y-2">
                <label for="display_name" class="text-sm font-semibold">Display name</label>
                <input id="display_name" name="display_name" type="text" value="{{ old('display_name') }}" required class="form-field" />
            </div>
            <div class="space-y-2">
                <label for="email" class="text-sm font-semibold">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="form-field" />
            </div>
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
            <div class="space-y-2">
                <label for="location" class="text-sm font-semibold">Location</label>
                <input id="location" name="location" type="text" value="{{ old('location') }}" class="form-field" />
            </div>
            <div class="space-y-2">
                <label for="website_url" class="text-sm font-semibold">Website</label>
                <input id="website_url" name="website_url" type="url" value="{{ old('website_url') }}" class="form-field" />
            </div>
        </div>

        <div class="space-y-2">
            <label for="about_me" class="text-sm font-semibold">About</label>
            <textarea id="about_me" name="about_me" class="form-field form-field--area min-h-[140px]">{{ old('about_me') }}</textarea>
        </div>

        <div class="grid gap-6 sm:grid-cols-4">
            <div class="space-y-2">
                <label for="age" class="text-sm font-semibold">Age</label>
                <input id="age" name="age" type="number" min="0" value="{{ old('age') }}" class="form-field" />
            </div>
            <div class="space-y-2">
                <label for="reputation" class="text-sm font-semibold">Reputation</label>
                <input id="reputation" name="reputation" type="number" min="0" value="{{ old('reputation') }}" class="form-field" />
            </div>
            <div class="space-y-2">
                <label for="up_votes" class="text-sm font-semibold">Up votes</label>
                <input id="up_votes" name="up_votes" type="number" min="0" value="{{ old('up_votes') }}" class="form-field" />
            </div>
            <div class="space-y-2">
                <label for="down_votes" class="text-sm font-semibold">Down votes</label>
                <input id="down_votes" name="down_votes" type="number" min="0" value="{{ old('down_votes') }}" class="form-field" />
            </div>
        </div>

        <div class="space-y-2">
            <label for="views" class="text-sm font-semibold">Profile views</label>
            <input id="views" name="views" type="number" min="0" value="{{ old('views') }}" class="form-field" />
        </div>

        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('users.index') }}" class="text-sm font-semibold link-muted">Cancel</a>
            <button type="submit" class="cta-button">Create user</button>
        </div>
    </form>
@endsection

@section('side-menu')
    <div class="space-y-4 text-sm text-muted">
        <h2 class="heading-secondary">Onboarding checklist</h2>
        <ul class="list-disc space-y-2 pl-5">
            <li>Confirm the email address before inviting the user.</li>
            <li>Set a sensible starting reputation and votes.</li>
            <li>Encourage completing the profile after first login.</li>
        </ul>
    </div>
@endsection
