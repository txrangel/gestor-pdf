<?php

namespace App\Policies;

use App\Models\Request;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RequestPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('request.index');
    }

    public function view(User $user, Request $request): bool
    {
        return $user->hasPermission('request.view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('request.create');
    }

    public function update(User $user, Request $request): bool
    {
        return $user->hasPermission('request.edit');
    }

    public function delete(User $user, Request $request): bool
    {
        return $user->hasPermission('request.destroy');
    }
}