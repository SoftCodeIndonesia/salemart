<?php

namespace App\Models;

use App\Models\RulesModel;
use App\Models\UserDevice;
use App\Models\UsersModel;
use App\Models\UserInfoModel;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UsersModel extends Authenticatable implements JWTSubject
{

    use HasFactory;
    use Notifiable;
    

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    // protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'email', 'password','is_actived',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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
    protected $rules;
    protected $user_info;
    protected $device;

    public function generate_id()
    {
        $rules_all = UsersModel::all()->count();

        $key = time() . ($rules_all + 1);

        $id = Hash::make($key);
        
        $data['user_id'] = $id;
        return $this->set_data($data);
    }

    public function set_data($data = [])
    {
        
        $data = (object) $data;
        if(key_exists('user_id', $data))
            $this->user_id = $data->user_id;
        if(key_exists('rules_id', $data))
            $this->rules_id = $data->rules_id;
        if(key_exists('username', $data))
            $this->username = $data->username;
        if(key_exists('avatar_url', $data))
            $this->avatar_url = $data->avatar_url;
        if(key_exists('email', $data))
            $this->email = $data->email;
        if(key_exists('email_is_verify', $data))
            $this->email_is_verify = (int) $this->email_is_verify;
        if(key_exists('email_verify_at', $data))
            $this->email_verify_at = (int) $this->email_verify_at ?? 0;
        if(key_exists('email_verify_id', $data))
            $this->email_verify_id = $data->email_verify_id;
        if(key_exists('email_verify_id_expired', $data))
            $this->email_verify_id_expired = (int) $data->email_verify_id_expired;
        if(key_exists('password', $data))
            $this->password = Hash::make($data->password);
        if(key_exists('country_code', $data))
            $this->country_code = $data->country_code;
        if(key_exists('country', $data))
            $this->country = $data->country;
        if(key_exists('is_actived', $data))
            $this->is_actived = (int) $data->is_actived;
        if(key_exists('register_at', $data)){
            $this->register_at = (int) $data->register_at;
        }else{
            $this->register_at = time();
        }
        if(key_exists('rules', $data)){
            $rules = new RulesModel;
            $rules->set_data($data->rules);
            $this->rules = $rules->get_data();
        }
        if(key_exists('user_info', $data)){
            $info = new UserInfoModel;
            $info->set_data($data->user_info);
            $this->user_info = $info->get_attribute();
           
        }
        if(key_exists('device', $data)){
            $deviceModel = new UserDevice;
            $deviceModel->set_data($data->device);
            $this->device = $deviceModel->get_attribute();
           
        }
            
    }

    public function get_attribute(){
        $data['user_id'] = $this->user_id;
        $data['username'] = $this->username;
        $data['avatar_url'] = $this->avatar_url;
        $data['email'] = $this->email;
        $data['email_is_verify'] = $this->email_is_verify;
        $data['email_verify_at'] = $this->email_verify_at;
        $data['email_verify_id'] = $this->email_verify_id;
        $data['email_verify_id_expired'] = $this->email_verify_id_expired;
        $data['country_code'] = $this->country_code;
        $data['country'] = $this->country;
        $data['is_actived'] = $this->is_actived;
        $data['register_at'] = $this->register_at;
        $data['rules'] = $this->rules ?? null;
        $data['user_info'] = $this->user_info ?? null;
        $data['device'] = $this->device ?? null;

        return (object) $data;
    }

    public function create(){
        
        $dataUser = $this->get_attribute();
        unset($dataUser->rules);
        $dataUser->rules_id = $this->rules_id;
        $dataUser->password = $this->password;
        
        $id = DB::table($this->table)->insertGetId((array) $dataUser);
        
        $this->set_data(['user_id' => $id]);

        $user = $this->findOne(['user_id'])->chain(['rules']);
        // var_dump($user->user);
        // die;
        $this->set_data($user->user[0]->attributes);
        $data = $this->get_attribute();

        return $data; 
    }

    public function findOne($cond){

        switch ($cond) {
            case 'user_id':
                $this->user = UsersModel::where('user_id', $this->user_id)->get();
                break;
            default:
                $this->user = UsersModel::where('user_id', $this->user_id)->get();
                break;
        }

        
        return $this;
    }
    public function findAll(){
        $this->user = UsersModel::all();
        return $this;
    }

    public function rules(){
       $rules = new RulesModel;
   
       foreach ($this->user as $key => $value) {
           
            $rulesData = $rules->findOne(['rules_id' => $value->attributes['rules_id']]);

            if($rulesData){
                $value->attributes['rules'] = $rulesData;
            }

            
       }
       return $this;
    }

    public function user_info()
    {
       
        foreach ($this->user as $key => $value) {
            $user_info = UserInfoModel::where('user_id', $value->attributes['user_id'])->get()->first();
            $value->attributes['user_info'] = $user_info->attributes;
       }

      
       return $this;
    }
    public function device()
    {
       
        foreach ($this->user as $key => $value) {
            $device = UserDevice::where('user_id', $value->attributes['user_id'])->get()->first();
            $value->attributes['device'] = $device->attributes;
       }

      
       return $this;
    }

    public function chain($data = []){
        foreach ($data as $key => $value) {
            $this->$value();
        }

        return $this;
    }

    public function show()
    {
        $data = [];

        if($this->user_id != null){
            
            $user = $this->findOne('rules_id')->chain(['rules','user_info', 'device']);
            $this->set_data($user->user[0]->attributes);
            $data = $this->get_attribute();
        }else{
            $users = $this->findAll()->chain(['rules','user_info', 'device']);
            foreach ($users->user as $key => $value) {
                $this->set_data($value->attributes);
                array_push($data, $this->get_attribute());
            }
        }

        return $data;
    }

    public function generate_code_verification($length) {
        $result = '';
    
        for($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }
    
        return $result;
    }

    public function user_id()
    {
        return $this->user_id;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

}