<?php

namespace Database\Seeders;

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
        $rules = ['developer', 'owner'];
        foreach ($rules as $key => $value) {
            $key = time() . $key;

            $id = Hash::make($key);

            DB::table('rules')->insert([
                'rules_id' => $id,
                'name' => $value,
                'created_at' => time(),
            ]);
        }
    }
}