<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsersController extends BaseController
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request): Response
    {
        $search = $request->string('q')->toString();
        $users = $this->userService->paginate($search ?: null, 20)->withQueryString();

        return response()->view('public.users.index', [
            'users' => $users,
            'search' => $search,
        ]);
    }

    public function create(): Response
    {
        return response()->view('public.users.create');
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

        return redirect()
            ->route('users.show', ['user' => $user->id])
            ->with('status', trans('messages.user.created'));
    }

    public function show(Request $request, int $id)
    {
        return app(UserController::class)->show($request, $id);
    }

    public function edit(Request $request, int $id)
    {
        return app(UserController::class)->edit($request, $id);
    }

    public function update(UserRequest $request, int $id): JsonResponse|RedirectResponse
    {
        $user = User::query()->findOrFail($id);
        $updated = $this->userService->update($user, $request->validated());

        if ($request->wantsJson()) {
            return response()->json([
                'message' => trans('messages.user.updated'),
                'user' => $updated,
            ]);
        }

        return redirect()
            ->route('users.show', ['user' => $updated->id])
            ->with('status', trans('messages.user.updated'));
    }

    public function destroy(Request $request, int $id)
    {
        return app(UserController::class)->destroy($request, $id);
    }
}
