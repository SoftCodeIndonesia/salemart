<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PermissionHolderModel;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PermissionHolderModel::truncate();
        PermissionHolderModel::defaultData();
    }
}