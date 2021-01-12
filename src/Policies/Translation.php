<?php

namespace Armincms\NovaTranslation\Policies;
 
use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class Translation
{
    use HandlesAuthorization; 
 
    /**
     * Determine whether the user can create given models.
     *
     * @param  \Component\Acl\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the given model.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function update(User $user, Model $model)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the given model.
     *
     * @param  \Component\Acl\User  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function delete(User $user, Model $model)
    {
        return true;
    } 
}
