<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PermissionRulesModel;

class PermissionRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PermissionRulesModel::truncate();
        PermissionRulesModel::defaultData();
    }
}