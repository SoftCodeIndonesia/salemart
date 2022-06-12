<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserInfoModel extends Model
{
    use HasFactory;

    protected $table = 'users_info';
    protected $primaryKey = 'user_info_id';
    // protected $keyType = 'string';
    public $timestamps = false;


    protected $user_info_id;
    protected $user_id;
    protected $is_actived = 0;
    protected $active_at = 0;
    protected $last_actived = 0;

    public function set_data($data = [])
    {
        $data = (object) $data;

        if(key_exists('user_info_id', $data))
            $this->user_info_id = $data->user_info_id;
        if(key_exists('user_id', $data))
            $this->user_id = $data->user_id;
        if(key_exists('is_actived', $data))
            $this->is_actived = (int) $data->is_actived;
        if(key_exists('active_at', $data))
            $this->active_at = (int) $data->active_at;
        if(key_exists('last_actived', $data))
            $this->last_actived = (int) $data->last_actived;
    }
    public function get_attribute()
    {
        
        $data['user_info_id'] = $this->user_info_id;
        $data['user_id'] = $this->user_id;
        $data['is_actived'] = (int) $this->is_actived;
        $data['active_at'] = (int) $this->active_at;
        $data['last_actived'] = (int) $this->last_actived;

        return (object) $data;
        
    }

    public function generate_id()
    {
        $rules_all = UserInfoModel::all()->count();

        $key = time() . ($rules_all + 1);

        $id = Hash::make($key);
        
        $data['user_info_id'] = $id;
        return $this->set_data($data);
    }
}