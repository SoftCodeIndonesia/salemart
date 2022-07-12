<?php

namespace App\Policies;

use App\Models\FeatureModel;
use App\Models\LoginModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class FeatureModelPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\LoginModel  $loginModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(LoginModel $loginModel)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\LoginModel  $loginModel
     * @param  \App\Models\FeatureModel  $featureModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(LoginModel $loginModel, FeatureModel $featureModel)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\LoginModel  $loginModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(LoginModel $loginModel)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\LoginModel  $loginModel
     * @param  \App\Models\FeatureModel  $featureModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(LoginModel $loginModel, FeatureModel $featureModel)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\LoginModel  $loginModel
     * @param  \App\Models\FeatureModel  $featureModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(LoginModel $loginModel, FeatureModel $featureModel)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\LoginModel  $loginModel
     * @param  \App\Models\FeatureModel  $featureModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(LoginModel $loginModel, FeatureModel $featureModel)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\LoginModel  $loginModel
     * @param  \App\Models\FeatureModel  $featureModel
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(LoginModel $loginModel, FeatureModel $featureModel)
    {
        //
    }
}
