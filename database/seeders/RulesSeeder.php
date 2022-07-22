<?php

namespace Database\Seeders;

use App\Models\RulesModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RulesModel::truncate();
        $rules = ['developer'];
        foreach ($rules as $key => $value) {
            $key = time() . $key;

            $id = Hash::make($key);

            DB::table('rules')->insert([
                'rules_id' => $id,
                'description' => 'rules for developer',
                'name' => $value,
                'created_at' => time(),
            ]);
        }
    }
}