<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        $users = User::paginate(10);

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create(): Renderable
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @param CreateNewUser $action
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request, CreateNewUser $action): RedirectResponse
    {
        $action->create([
            ...$request->validated(),
            'terms' => 'on',
            'password_confirmation' => $request->password_confirmation,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Renderable
     */
    public function edit(User $user): Renderable
    {
        $permissions = Permission::all();
        $roles = Role::all();

        return view('admin.users.edit', [
            'user' => $user,
            'permissions' => $permissions,
            'roles' => $roles,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @param UpdateUserProfileInformation $action
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user, UpdateUserProfileInformation $action): RedirectResponse
    {
        $action->update($user, $request->validated());

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()
            ->route('admin.home.index')
            ->with('success', 'User deleted successfully.');
    }

}
