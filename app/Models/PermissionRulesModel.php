<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermissionRulesModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'stakeholder_permission_rules';
    protected $fillable = ['permission_id', 'rules_id', 'last_updated', 'created_by'];
    public $timestamps = false;

    protected $id;
    protected $permission_id;
    protected $rules_id;
    protected $last_updated;
    protected $created_by;

    public function set_data($data = []){
        
        $data = (object) $data;
        if(key_exists('id', $data))
            $this->id = (int) $data->id;
        if(key_exists('permission_id', $data))
            $this->permission_id = (int) $data->permission_id;
        if(key_exists('rules_id', $data))
            $this->rules_id = $data->rules_id;
        if(key_exists('last_updated', $data))
            $this->last_updated = $data->last_updated ?? time();
        if(key_exists('created_by', $data))
            $this->created_by = $data->created_by;
        
    }

    static function defaultData(){
        $permission = PermissionHolderModel::all();

        $rules = DB::table('rules')->where('name', 'developer')->get()->first();

        foreach ($permission as $key => $value) {
            $data = [
                'permission_id' => $value->id,
                'rules_id' => $rules->rules_id,
                'last_updated' => time(),
                'created_by' => 'system'
            ];
            PermissionRulesModel::create($data);
        }
        
    }
}