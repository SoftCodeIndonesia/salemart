<?php

namespace App\Models;

use App\Models\RulesModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RulesModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'rules_id';
    protected $table = 'rules';
    public $timestamps = false;

    protected $rules_id;
    protected $name;
    protected $created_at;


    public function set_data($data = []){
        $data = (object) $data;
        if(key_exists('rules_id', $data))
            $this->rules_id = (string) $data->rules_id;
        if(key_exists('name', $data))
            $this->name = $data->name;
        if(key_exists('created_at', $data)){
            $this->created_at = (int) $data->created_at;
        }else{
            $this->created_at = time();
        }
    }

    public function findOne($cond)
    {
        $data = RulesModel::where($cond)->get()->first();
        $this->set_data($data->attributes);
        return $this->get_data();
    }

    public function get_data()
    {
        $data['rules_id'] = $this->rules_id;
        $data['name'] = $this->name;
        $data['created_at'] = $this->created_at;

        return (object) $data;
    }

    public function create(){
        $this->generate_id();

        $id = DB::table($this->table)->insertGetId(
                [
                'rules_id' => $this->rules_id,
                'name' => $this->name,
                'created_at' => $this->created_at
            ]
        );

        $data = DB::table($this->table)->where('rules_id', $id)->first();

        $this->set_data((object) $data);
        
        return $this->get_data();
    }

    private function generate_id(){
        $rules_all = RulesModel::all()->count();

        $key = time() . ($rules_all + 1);

        $data['rules_id'] = Hash::make($key);

        $this->set_data((object) $data);
    }
}