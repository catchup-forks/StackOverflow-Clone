<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService
{
    public function paginate(?string $search = null, int $perPage = 15): LengthAwarePaginator
    {
        return User::query()
            ->when($search, fn ($query) => $query->where('display_name', 'like', '%' . $search . '%'))
            ->orderByDesc('creation_date')
            ->paginate($perPage);
    }

    public function create(array $data): User
    {
        $user = User::query()->create([
            'display_name' => $data['display_name'],
            'email' => $data['email'],
            'password' => isset($data['password']) ? Hash::make($data['password']) : null,
            'creation_date' => now(),
            'last_access_date' => now(),
            'reputation' => $data['reputation'] ?? 0,
            'views' => $data['views'] ?? 0,
            'up_votes' => $data['up_votes'] ?? 0,
            'down_votes' => $data['down_votes'] ?? 0,
        ]);

        $roles = $data['roles'] ?? ['user'];

        collect($roles)->each(fn (string $role) => Role::query()->firstOrCreate([
            'name' => $role,
            'guard_name' => 'web',
        ]));

        $user->syncRoles($roles);

        return $user;
    }

    public function update(User $user, array $data): User
    {
        $user->fill([
            'display_name' => $data['display_name'],
            'email' => $data['email'],
            'reputation' => $data['reputation'] ?? $user->reputation,
            'views' => $data['views'] ?? $user->views,
            'up_votes' => $data['up_votes'] ?? $user->up_votes,
            'down_votes' => $data['down_votes'] ?? $user->down_votes,
            'age' => $data['age'] ?? $user->age,
        ]);

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        if (array_key_exists('roles', $data)) {
            $roles = $data['roles'] ?? [];

            collect($roles)->each(fn (string $role) => Role::query()->firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]));

            $user->syncRoles($roles);
        }

        return $user->refresh();
    }

    public function updatePassword(User $user, string $password): void
    {
        $user->forceFill([
            'password' => Hash::make($password),
        ])->save();
    }

    public function findWithRecentPosts(int $userId): User
    {
        return User::query()
            ->with([
                'posts' => fn ($query) => $query->orderByDesc('creation_date')->limit(5),
                'profile',
            ])
            ->findOrFail($userId);
    }
}
