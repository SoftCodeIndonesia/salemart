<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RulesSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\StakeholderFeatSheed;
use Database\Seeders\PermissionRulesSeeder;
use Database\Seeders\UserHolderPermissionSeed;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $rulesSheed = new RulesSeeder();
       $userSheed = new userSeeder();
       $holderFeat = new StakeholderFeatSheed();
       $permissionFeat = new PermissionSeeder();
       $permissionRules = new PermissionRulesSeeder();
       $holderPeermission = new UserHolderPermissionSeed();

       $rulesSheed->run();
       $userSheed->run();
       $holderFeat->run();
       $permissionFeat->run();
       $permissionRules->run();
    }
}