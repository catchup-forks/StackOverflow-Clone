<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class UsersController extends BaseController
{
    public function index(Request $request): Response
    {
        $query = User::query();

        if ($term = $request->get('q')) {
            $query->where('display_name', 'like', '%' . $term . '%');
        }

        $users = $query->orderByDesc('reputation')->paginate(20)->withQueryString();

        return response()->view('public.users.index', [
            'users' => $users,
            'search' => $request->get('q'),
        ]);
    }

    public function create(): Response
    {
        return response()->view('public.users.create');
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'display_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'location' => ['nullable', 'string', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'about_me' => ['nullable', 'string'],
            'age' => ['nullable', 'integer', 'min:0'],
            'reputation' => ['nullable', 'integer', 'min:0'],
            'views' => ['nullable', 'integer', 'min:0'],
            'up_votes' => ['nullable', 'integer', 'min:0'],
            'down_votes' => ['nullable', 'integer', 'min:0'],
        ]);

        $user = User::create([
            'display_name' => $data['display_name'],
            'email' => $data['email'],
            'location' => $data['location'] ?? '',
            'website_url' => $data['website_url'] ?? '',
            'about_me' => $data['about_me'] ?? '',
            'age' => $data['age'] ?? null,
            'reputation' => $data['reputation'] ?? 0,
            'views' => $data['views'] ?? 0,
            'up_votes' => $data['up_votes'] ?? 0,
            'down_votes' => $data['down_votes'] ?? 0,
            'creation_date' => now(),
            'last_access_date' => now(),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'User created.',
                'user' => $user,
            ], 201);
        }

        return redirect()
            ->route('user.show', ['user' => $user->id])
            ->with('status', 'User created.');
    }

    public function show(Request $request, int $id)
    {
        return app(UserController::class)->show($request, $id);
    }

    public function edit(Request $request, int $id)
    {
        return app(UserController::class)->edit($request, $id);
    }

    public function update(Request $request, int $id)
    {
        return app(UserController::class)->update($request, $id);
    }

    public function destroy(Request $request, int $id)
    {
        return app(UserController::class)->destroy($request, $id);
    }
}
