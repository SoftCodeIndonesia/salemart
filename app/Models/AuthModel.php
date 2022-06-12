<?php

namespace App\Models;

use App\Models\UsersModel;
use App\Mail\UserVerification;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuthModel extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
   

    protected $user_id;
    protected $rules_id;
    protected $username;
    protected $avatar_url;
    protected $email;
    protected $email_is_verify;
    protected $email_verify_at;
    protected $email_verify_id;
    protected $email_verify_id_expired;
    protected $password;
    protected $country_code;
    protected $country;
    protected $is_actived;
    protected $register_at;

    public function set_data($data = [])
    {
        $data = (object) $data;
        if(key_exists('rules_id', $data))
            $this->rules_id = $data->rules_id;
        if(key_exists('username', $data))
            $this->username = $data->username;
        if(key_exists('email', $data))
            $this->email = $data->email;
        if(key_exists('email_verify_id', $data))
            $this->email_verify_id = $data->email_verify_id;
        if(key_exists('email_verify_id_expired', $data))
            $this->email_verify_id_expired = (int) $data->email_verify_id_expired;
        if(key_exists('password', $data))
            $this->password = $data->password;
        if(key_exists('country_code', $data))
            $this->country_code = $data->country_code;
        if(key_exists('country', $data))
            $this->country = $data->country;
    }

    public function get_attribute(){
        $data['rules_id'] = $this->rules_id;
        $data['username'] = $this->username;
        $data['email_verify_id_expired'] = $this->email_verify_id_expired;
        $data['email_verify_id'] = $this->email_verify_id;
        $data['email'] = $this->email;
        $data['password'] = $this->password;
        $data['country_code'] = $this->country_code;
        $data['country'] = $this->country;

        return (object) $data;
    }


    public function create()
    {
        $userModel = new UsersModel;
        $userModel->set_data($this->get_attribute());
        $userModel->generate_id();
        $user = $userModel->create();
       
        return $user;
    }
    public function auth()
    {

    }

    

    
}