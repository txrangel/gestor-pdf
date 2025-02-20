<?php

namespace App\Policies;

use App\Models\Txt;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TxtPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('txt.index');
    }

    public function view(User $user, Txt $txt): bool
    {
        return $user->hasPermission('txt.view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('txt.create');
    }

    public function update(User $user, Txt $txt): bool
    {
        return $user->hasPermission('txt.edit');
    }

    public function delete(User $user, Txt $txt): bool
    {
        return $user->hasPermission('txt.destroy');
    }
}