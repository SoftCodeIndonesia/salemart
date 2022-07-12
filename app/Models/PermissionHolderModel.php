<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermissionHolderModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'stakeholder_permission';
    protected $fillable = ['feature_id', 'permission', 'last_updated', 'created_by'];
    public $timestamps = false;

    protected $id;
    protected $feature_id;
    protected $permission;
    protected $last_updated;
    protected $created_by;

    public function set_data($data = []){
        
        $data = (object) $data;
        if(key_exists('id', $data))
            $this->id = (int) $data->id;
        if(key_exists('feature_id', $data))
            $this->feature_id = (int) $data->feature_id;
        if(key_exists('permission', $data))
            $this->permission = $data->permission;
        if(key_exists('last_updated', $data))
            $this->last_updated = $data->last_updated ?? time();
        if(key_exists('created_by', $data))
            $this->created_by = $data->created_by;
        
    }

    static function defaultData(){
        $feat = DB::table('stakeholder_feature')->where('feature_name', 'feature')->get()->first();

        $permissionData = [
            [
                'feature_id' => $feat->feature_id,
                'permission' => 'create feature',
                'last_updated' => time(),
                'created_by' => 'system'
            ],
            [
                'feature_id' => $feat->feature_id,
                'permission' => 'read feature',
                'last_updated' => time(),
                'created_by' => 'system'
            ],
            [
                'feature_id' => $feat->feature_id,
                'permission' => 'update feature',
                'last_updated' => time(),
                'created_by' => 'system'
            ],
            [
                'feature_id' => $feat->feature_id,
                'permission' => 'delete feature',
                'last_updated' => time(),
                'created_by' => 'system'
            ],
        ];
        foreach ($permissionData as $key => $value) {
            PermissionHolderModel::create($value);
            
        }
        
    }
}