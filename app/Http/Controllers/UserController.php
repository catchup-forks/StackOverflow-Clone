<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\ProfileService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function index(Request $request): JsonResponse|View
    {
        $search = $request->string('q')->toString();
        $users = $this->userService->paginate($search ?: null);

        if ($request->wantsJson()) {
            return response()->json($users);
        }

        return view('public.users.index', [
            'users' => $users,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('public.users.create');
    }

    public function store(UserRequest $request): JsonResponse|RedirectResponse
    {
        $user = $this->userService->create($request->validated());

        if ($request->wantsJson()) {
            return response()->json([
                'message' => trans('messages.user.created'),
                'user' => $user,
            ], 201);
        }

        return redirect()->route('users.show', $user)->with('status', trans('messages.user.created'));
    }

    public function show(Request $request, User $user): JsonResponse|View
    {
        $userWithPosts = $this->userService->findWithRecentPosts($user->id);

        if ($request->wantsJson()) {
            return response()->json($userWithPosts);
        }

        return view('public.user.show', [
            'user' => $userWithPosts,
            'recentPosts' => $userWithPosts->posts,
        ]);
    }

    public function edit(User $user): View
    {
        return view('public.user.edit', ['user' => $user]);
    }

    public function update(UserRequest $request, User $user): JsonResponse|RedirectResponse
    {
        $user = $this->userService->update($user, $request->validated());

        if ($request->wantsJson()) {
            return response()->json([
                'message' => trans('messages.user.updated'),
                'user' => $user,
            ]);
        }

        return redirect()->route('users.show', $user)->with('status', trans('messages.user.updated'));
    }

    public function updatePassword(PasswordUpdateRequest $request, User $user): JsonResponse|RedirectResponse
    {
        $authUser = $request->user();

        if (! $authUser || $authUser->id !== $user->id) {
            abort(403);
        }

        if (! Hash::check($request->input('current_password'), $user->password ?? '')) {
            return back()->withErrors(['current_password' => trans('messages.user.invalid_password')]);
        }

        $this->userService->updatePassword($user, $request->input('password'));

        if ($request->wantsJson()) {
            return response()->json(['message' => trans('messages.user.password_updated')]);
        }

        return redirect()->route('users.show', $user)->with('status', trans('messages.user.password_updated'));
    }

    public function updateProfile(ProfileRequest $request, User $user, ProfileService $profileService): JsonResponse|RedirectResponse
    {
        $authUser = $request->user();

        if (! $authUser || $authUser->id !== $user->id) {
            abort(403);
        }

        $profile = $profileService->update($user, $request->validated());

        if ($request->wantsJson()) {
            return response()->json([
                'message' => trans('messages.user.profile_updated'),
                'profile' => $profile,
            ]);
        }

        return redirect()->route('users.show', $user)->with('status', trans('messages.user.profile_updated'));
    }

    public function destroy(Request $request, User $user): JsonResponse|RedirectResponse
    {
        $user->delete();

        if ($request->wantsJson()) {
            return response()->json(['message' => trans('messages.user.deleted')]);
        }

        return redirect()->route('users.index')->with('status', trans('messages.user.deleted'));
    }
}
