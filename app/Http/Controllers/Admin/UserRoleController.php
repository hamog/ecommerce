<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function __invoke(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'sometimes|string|exists:\App\Models\Role,name',
        ]);

        $user->syncRoles($data['roles']);

        return redirect()
            ->back(fallback: route('admin.users.edit', $user))
            ->with('success', 'User roles updated successfully.');
    }
}
