<?php

namespace App\Policies;

use App\Models\Pdf;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PdfPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('pdf.index');
    }

    public function view(User $user, Pdf $pdf): bool
    {
        return $user->hasPermission('pdf.view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('pdf.create');
    }

    public function update(User $user, Pdf $pdf): bool
    {
        return $user->hasPermission('pdf.edit');
    }

    public function delete(User $user, Pdf $pdf): bool
    {
        return $user->hasPermission('pdf.destroy');
    }
}