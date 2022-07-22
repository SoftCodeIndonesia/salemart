<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserHolderPermissionModel;

class UserHolderPermissionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserHolderPermissionModel::truncate();
        UserHolderPermissionModel::defaultData('developer');
    }
}