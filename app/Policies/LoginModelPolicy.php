<?php

namespace App\Policies;

use App\Models\LoginModel;
use App\Models\UsersModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class LoginModelPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\UsersModel  $usersModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(UsersModel $usersModel)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\UsersModel  $usersModel
     * @param  \App\Models\LoginModel  $loginModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(UsersModel $usersModel, LoginModel $loginModel)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\UsersModel  $usersModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(UsersModel $usersModel)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\UsersModel  $usersModel
     * @param  \App\Models\LoginModel  $loginModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(UsersModel $usersModel, LoginModel $loginModel)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\UsersModel  $usersModel
     * @param  \App\Models\LoginModel  $loginModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(UsersModel $usersModel, LoginModel $loginModel)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\UsersModel  $usersModel
     * @param  \App\Models\LoginModel  $loginModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(UsersModel $usersModel, LoginModel $loginModel)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\UsersModel  $usersModel
     * @param  \App\Models\LoginModel  $loginModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(UsersModel $usersModel, LoginModel $loginModel)
    {
        //
    }
}
