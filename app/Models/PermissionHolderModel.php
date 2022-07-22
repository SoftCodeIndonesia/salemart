<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\Models\PermissionRulesModel;
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

    public function permissionRules()
    {
        return $this->belongsTo(StakeholderFeat::class, 'id');
    }

    static function defaultData(){
        $feat = DB::table('stakeholder_feature')->get();

        foreach ($feat as $key => $value) {
            $permissionData = [
                [
                    'feature_id' => $value->feature_id,
                    'permission' => 'create ' . $value->feature_name,
                    'last_updated' => time(),
                    'created_by' => 'system'
                ],
                [
                    'feature_id' => $value->feature_id,
                    'permission' => 'read ' . $value->feature_name,
                    'last_updated' => time(),
                    'created_by' => 'system'
                ],
                [
                    'feature_id' => $value->feature_id,
                    'permission' => 'update ' . $value->feature_name,
                    'last_updated' => time(),
                    'created_by' => 'system'
                ],
                [
                    'feature_id' => $value->feature_id,
                    'permission' => 'delete ' . $value->feature_name,
                    'last_updated' => time(),
                    'created_by' => 'system'
                ],
            ];
            foreach ($permissionData as $key => $value) {
                PermissionHolderModel::create($value);
                
            }
        }
        
    }
}