<?php

namespace App\Models;

use App\Models\StoreModel;
use App\Models\UsersModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'store_id';
    protected $table = 'stores';
    public $timestamps = false;
    protected $nullable = ['address_id', 'logo_url'];

    protected $storeId;
    protected $userId;
    protected $addressId;
    protected $storeName;
    protected $logoUrl;
    protected $createdAt;
    protected $lastUpdated;
    protected $createdBy;
    protected $owner;


    public function set_data($data = [])
    {
        $data = (object) $data;
        
        if(key_exists('store_id', $data))
            $this->storeId = $data->store_id;
        if(key_exists('user_id', $data))
            $this->userId = $data->user_id;
        if(key_exists('address_id', $data))
            $this->addressId = $data->address_id;
        if(key_exists('store_name', $data))
            $this->storeName = $data->store_name;
        if(key_exists('logo_url', $data))
            $this->logoUrl = $data->logo_url;
        if(key_exists('created_at', $data))
            $this->createdAt = $data->created_at;
        if(key_exists('last_updated', $data))
            $this->lastUpdated = $data->last_updated;
        if(key_exists('created_by', $data))
            $this->createdBy = $data->created_by;
        if(key_exists('owner', $data))
            $this->owner = $data->owner;
    }

    public function get_data()
    {
        
        $data['store_id'] = $this->storeId;
        $data['user_id'] = $this->userId;
        $data['address_id'] = $this->addressId;
        $data['store_name'] = $this->storeName;
        $data['logo_url'] = $this->logoUrl;
        $data['created_at'] = $this->createdAt;
        $data['last_updated'] = $this->lastUpdated;
        $data['created_by'] = $this->createdBy;
        
        if(isset($this->owner))
            $data['owner'] = $this->owner;

        return (object) $data;
        
    }

    public function create()
    {
        $this->generate_id();
        return DB::table($this->table)->insert((array) $this->get_data());
    }

    public function run()
    {
        return $this->data;
    }

    public function byId()
    {

        $this->data = StoreModel::where('store_id', $this->storeId);
        return $this;
    }

    public function byOwner()
    {
        $this->data = DB::table($this->table)->where('user_id', $this->userId);
        return $this;
    }

    public function include($data = [])
    {
        
        foreach ($data as $key => $value) {
            $this->$value();
        }

        return $this;
    }

    public function owner()
    {

        
        $data = [];

        $userModel = new UsersModel;

        // if()
        
        foreach ($this->data as $key => $value) {
            $userModel->set_data(['user_id' => $value->user_id]);
            $user = (array) $userModel->show();
            unset($user['user_info']);
            unset($user['device']);
            
            $value = (array) $value;

            $value['owner'] = $user;
            $this->set_data($value);

            array_push($data, $this->get_data());
        }

        $this->data = $data;

        return $this;
    }

    private function creator()
    {
        $data = [];

        $userModel = new UsersModel;
        
        foreach ($this->data as $key => $value) {
            $userModel->set_data(['user_id' => $value->created_by]);
            $user = (array) $userModel->show();
            unset($user['user_info']);
            unset($user['device']);
            
            $value = (array) $value;

            $value['created_by'] = $user;
            $this->set_data($value);

            array_push($data, $this->get_data());
        }

        $this->data = $data;

        return $this;   
    }
    
    
    public function byUser()
    {
        $this->where('user_id', $this->userId)->get();
        return $this;
    }

    public function generate_id(){
        $store_all = StoreModel::all()->count();

        $key = time() . ($store_all + 1);

        $data['store_id'] = Hash::make($key);

        $this->set_data((object) $data);
    }

    public function getAll()
    {
        $store = [];
        $data = $this->data->get();
        foreach ($data as $key => $value) {
            $this->set_data($value);
            array_push($store, $this->get_data());
        }

        $this->data = $data;
        return $this;
    }

    public function deleteOne()
    {
        DB::table($this->table);
        return $this;
    }
    
}