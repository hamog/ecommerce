<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserPermissionController extends Controller
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
            'permissions' => 'required|array',
            'permissions.*' =>
                'sometimes|string|exists:\Spatie\Permission\Models\Permission,name',
        ]);

        $user->syncPermissions($data['permissions']);

        return redirect()
            ->back(fallback: route('admin.users.edit', $user))
            ->with('success', 'User permissions updated successfully.');
    }
}
