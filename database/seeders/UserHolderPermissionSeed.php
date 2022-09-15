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
        $permission = new UserHolderPermissionModel([]);
        $permission->truncate();
        $permission->truncate();
        $permission->defaultData('developer');
    }
}
