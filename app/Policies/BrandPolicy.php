<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class BrandPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view all brands');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $brand
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Brand $brand): bool
    {
        return $user->can('view brand', $brand);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user): bool
    {
        return $user->can('create brand');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $brand
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Brand $brand): bool
    {
        return $user->can('update brand', $brand);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $brand
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Brand $brand): bool
    {
        return $user->can('delete brand', $brand);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $brand
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Brand $brand): bool
    {
        return $user->can('restore brand', $brand);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $brand
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Brand $brand): bool
    {
        return $user->can('force delete brand', $brand);
    }
}
