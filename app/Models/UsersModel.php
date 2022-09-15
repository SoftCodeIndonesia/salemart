<?php

namespace App\Models;

use App\Models\RulesModel;
use App\Models\UserDevice;
use App\Models\UserInfoModel;
use App\Models\StakeholderFeat;
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
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'email', 'password', 'is_actived',
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
    protected $features;

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



        if (property_exists($data, 'user_id'))
            $this->user_id = $data->user_id;
        if (property_exists($data, 'rules_id')) {

            $this->rules_id = $data->rules_id;
        }
        if (property_exists($data, 'username'))
            $this->username = $data->username;
        if (property_exists($data, 'avatar_url'))
            $this->avatar_url = $data->avatar_url;
        if (property_exists($data, 'email'))
            $this->email = $data->email;
        if (property_exists($data, 'email_is_verify'))
            $this->email_is_verify = (int) $this->email_is_verify;
        if (property_exists($data, 'email_verify_at'))
            $this->email_verify_at = (int) $this->email_verify_at ?? 0;
        if (property_exists($data, 'email_verify_id'))
            $this->email_verify_id = $data->email_verify_id;
        if (property_exists($data, 'email_verify_id_expired'))
            $this->email_verify_id_expired = (int) $data->email_verify_id_expired;
        if (property_exists($data, 'password'))
            $this->password = Hash::make($data->password);
        if (property_exists($data, 'country_code'))
            $this->country_code = $data->country_code;
        if (property_exists($data, 'country'))
            $this->country = $data->country;
        if (property_exists($data, 'is_actived'))
            $this->is_actived = (int) $data->is_actived;
        if (property_exists($data, 'register_at')) {
            $this->register_at = (int) $data->register_at;
        } else {
            $this->register_at = time();
        }
        if (property_exists($data, 'rules')) {
            $rules = new RulesModel;
            $rules->set_data($data->rules);
            $this->rules = $rules->get_data();
        }
        if (property_exists($data, 'user_info')) {
            $info = new UserInfoModel;
            $info->set_data($data->user_info);
            $this->user_info = $info->get_attribute();
        }
        if (property_exists($data, 'device')) {
            $deviceModel = new UserDevice;
            $deviceModel->set_data($data->device);
            $this->device = $deviceModel->get_attribute();
        }

        if (property_exists($data, 'features')) {
            $this->features = $data->features;
        }
    }

    public function get_attribute()
    {
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
        $data['rules_id'] = $this->rules_id ?? '';
        $data['user_info'] = $this->user_info ?? null;
        $data['device'] = $this->device ?? null;
        $data['features'] = $this->features ?? [];

        return (object) $data;
    }

    public function create()
    {

        $dataUser = $this->get_attribute();
        unset($dataUser->rules);
        unset($dataUser->user_info);
        unset($dataUser->device);
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

    public function findOne($cond)
    {

        switch ($cond) {
            case 'user_id':

                $data = DB::table($this->table)->where('user_id', $this->user_id)->get()->first();

                $this->set_data($data);
                return $this;
            default:
                $data = DB::table($this->table)->where($cond, $this[$cond])->get()->first();

                $this->set_data($data);

                return $this;
        }
    }
    public function findAll()
    {
        $this->user = UsersModel::all();
        return $this;
    }

    public function rules()
    {

        $rules = new RulesModel;

        $rulesData = $rules->findOne(['rules_id' => $this->rules_id]);

        if ($rulesData) {
            $this->rules = $rulesData;
        }
        return $this;
    }

    public function user_info()
    {

        $user_info = UserInfoModel::where('user_id', $this->user_id)->get()->first();
        if ($user_info) {
            $this->user_info = $user_info;
        }


        return $this;
    }
    public function device()
    {
        $device = UserDevice::where('user_id', $this->user_id)->get()->first();

        if ($device)
            $this->device = $device;

        return $this;
    }

    public function features()
    {
        $feat = new StakeholderFeat(['user_id' => $this->user_id]);

        $features = $feat->findAllWithTree();

        if ($features)
            $this->features = $features;
        return $this;
    }

    public function chain($data = [])
    {

        foreach ($data as $key => $value) {
            $this->$value();
        }

        return $this;
    }

    public function show($attributes = ['rules', 'user_info', 'device'])
    {
        $data = [];

        if ($this->user_id != null) {

            $user = $this->findOne('user_id')->chain($attributes);

            $this->set_data($user->user[0]);
            $data = $this->get_attribute();
        } else {
            $users = $this->findAll()->chain($attributes);
            foreach ($users->user as $key => $value) {
                $this->set_data($value->attributes);
                array_push($data, $this->get_attribute());
            }
        }

        return $data;
    }

    public function generate_code_verification($length)
    {
        $result = '';

        for ($i = 0; $i < $length; $i++) {
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