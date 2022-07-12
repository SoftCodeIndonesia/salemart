<?php

namespace Database\Seeders;

use App\Models\RulesModel;
use App\Models\UsersModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UsersModel::truncate();
       
        $userModel = New UsersModel();

        $count = UsersModel::all()->count();

        $key = time() . ($count + 1);

        $id = Hash::make($key);

        $rules = DB::table('rules')->where('name', 'developer')->get()->first();

        $userModel->user_id = $id;
        $userModel->rules_id = $rules->rules_id;
        $userModel->username = 'developer';
        $userModel->password = Hash::make('123123123');
        $userModel->email = 'developer@gmail.com';
        $userModel->email_is_verify = 1;
        $userModel->email_verify_at = time();
        $userModel->email_verify_id = 123123;
        $userModel->email_verify_id_expired = time();
        $userModel->country_code = 'ID';
        $userModel->country = 'indonesia';
        $userModel->is_actived = 1;
        $userModel->register_at = time();

        $userModel->save();
    }
}