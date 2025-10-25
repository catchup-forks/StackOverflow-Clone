@extends('public.master')

@section('content')
    <header class="space-y-2">
        <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">Invite User</p>
        <h1 class="text-2xl font-semibold text-slate-900">Add a new community member</h1>
        <p class="text-sm text-slate-500">Capture key profile details to seed their account.</p>
    </header>

    <form action="{{ route('users.store') }}" method="POST" class="mt-8 space-y-6">
        @csrf

        <div class="grid gap-6 sm:grid-cols-2">
            <div class="space-y-2">
                <label for="display_name" class="text-sm font-semibold text-slate-700">Display name</label>
                <input id="display_name" name="display_name" type="text" value="{{ old('display_name') }}" required class="w-full rounded-2xl border border-slate-300 bg-white p-4 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" />
            </div>
            <div class="space-y-2">
                <label for="email" class="text-sm font-semibold text-slate-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-2xl border border-slate-300 bg-white p-4 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" />
            </div>
        </div>

        <div class="grid gap-6 sm:grid-cols-2">
            <div class="space-y-2">
                <label for="location" class="text-sm font-semibold text-slate-700">Location</label>
                <input id="location" name="location" type="text" value="{{ old('location') }}" class="w-full rounded-2xl border border-slate-300 bg-white p-4 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" />
            </div>
            <div class="space-y-2">
                <label for="website_url" class="text-sm font-semibold text-slate-700">Website</label>
                <input id="website_url" name="website_url" type="url" value="{{ old('website_url') }}" class="w-full rounded-2xl border border-slate-300 bg-white p-4 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" />
            </div>
        </div>

        <div class="space-y-2">
            <label for="about_me" class="text-sm font-semibold text-slate-700">About</label>
            <textarea id="about_me" name="about_me" class="min-h-[140px] w-full rounded-2xl border border-slate-300 bg-white p-4 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('about_me') }}</textarea>
        </div>

        <div class="grid gap-6 sm:grid-cols-4">
            <div class="space-y-2">
                <label for="age" class="text-sm font-semibold text-slate-700">Age</label>
                <input id="age" name="age" type="number" min="0" value="{{ old('age') }}" class="w-full rounded-2xl border border-slate-300 bg-white p-3 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" />
            </div>
            <div class="space-y-2">
                <label for="reputation" class="text-sm font-semibold text-slate-700">Reputation</label>
                <input id="reputation" name="reputation" type="number" min="0" value="{{ old('reputation') }}" class="w-full rounded-2xl border border-slate-300 bg-white p-3 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" />
            </div>
            <div class="space-y-2">
                <label for="up_votes" class="text-sm font-semibold text-slate-700">Up votes</label>
                <input id="up_votes" name="up_votes" type="number" min="0" value="{{ old('up_votes') }}" class="w-full rounded-2xl border border-slate-300 bg-white p-3 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" />
            </div>
            <div class="space-y-2">
                <label for="down_votes" class="text-sm font-semibold text-slate-700">Down votes</label>
                <input id="down_votes" name="down_votes" type="number" min="0" value="{{ old('down_votes') }}" class="w-full rounded-2xl border border-slate-300 bg-white p-3 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" />
            </div>
        </div>

        <div class="space-y-2">
            <label for="views" class="text-sm font-semibold text-slate-700">Profile views</label>
            <input id="views" name="views" type="number" min="0" value="{{ old('views') }}" class="w-full rounded-2xl border border-slate-300 bg-white p-3 text-sm text-slate-700 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" />
        </div>

        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('users.index') }}" class="text-sm font-semibold text-slate-600 hover:text-emerald-600">Cancel</a>
            <button type="submit" class="rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-emerald-400">Create user</button>
        </div>
    </form>
@endsection

@section('side-menu')
    <div class="space-y-4 text-sm text-slate-600">
        <h2 class="text-lg font-semibold text-slate-800">Onboarding checklist</h2>
        <ul class="list-disc space-y-2 pl-5">
            <li>Confirm the email address before inviting the user.</li>
            <li>Set a sensible starting reputation and votes.</li>
            <li>Encourage completing the profile after first login.</li>
        </ul>
    </div>
@endsection
