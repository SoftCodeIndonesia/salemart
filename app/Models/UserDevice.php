<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDevice extends Model
{
    use HasFactory;

    protected $table = 'user_devices';
    protected $primaryKey = 'user_devices_id';
    // protected $keyType = 'string';
    public $timestamps = false;

    protected $nullable = ['lang'];

    // protected $user_devices_id;
    // protected $user_id;
    // protected $lang;
    // protected $platform;
    // protected $version;
    // protected $name;
    // protected $identifier;
    // protected $fcm_token;
    // protected $last_updated;

    public function set_data($data = [])
    {
        $data = (object) $data;

        if(key_exists('user_devices_id', $data))
            $this->user_devices_id = $data->user_devices_id;
        if(key_exists('user_id', $data))
            $this->user_id = $data->user_id;
        if(key_exists('lang', $data))
            $this->lang = $data->lang;
        if(key_exists('platform', $data))
            $this->platform = $data->platform;
        if(key_exists('version', $data))
            $this->version = (int) $data->version;
        if(key_exists('name', $data))
            $this->name = $data->name;
        if(key_exists('identifier', $data))
            $this->identifier = $data->identifier;
        if(key_exists('fcm_token', $data))
            $this->fcm_token = $data->fcm_token;
        if(key_exists('last_updated', $data))
            $this->last_updated = (int) $data->last_updated;
        
    }

    public function get_attribute()
    {
        $data['user_devices_id'] = $this->user_devices_id;
        $data['user_id'] = $this->user_id;
        $data['lang'] = $this->lang;
        $data['platform'] = $this->platform;
        $data['version'] = (int) $this->version;
        $data['name'] = $this->name;
        $data['identifier'] = $this->identifier;
        $data['fcm_token'] = $this->fcm_token;
        $data['last_updated'] = (int) $this->last_updated;

        return (object) $data;
    }

    public function generate_id()
    {
        $rules_all = UserDevice::all()->count();

        $key = time() . ($rules_all + 1);

        $id = Hash::make($key);
        
        $data['user_devices_id'] = $id;
        return $this->set_data($data);
    }
}