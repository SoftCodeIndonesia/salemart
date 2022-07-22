<?php

namespace App\Models;


use App\Models\UsersModel;
use Illuminate\Support\Facades\DB;
use App\Models\PermissionRulesModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserHolderPermissionModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'user_holder_permission';
    protected $fillable = ['permission_id', 'user_id', 'last_updated', 'created_by'];
    public $timestamps = false;

    protected $id;
    protected $permission_id;
    protected $user_id;
    protected $last_updated;
    protected $created_by;

    protected $feature_id;

    public function __construct($data){
        $this->set_data($data);
    }
    

    public function set_data($data = []){
        
        $data = (object) $data;
        
       
        if(key_exists('id', $data))
            $this->id = (int) $data->id;
        if(key_exists('permission_id', $data))
            $this->permission_id = (int) $data->permission_id;
        if(key_exists('user_id', $data))
            $this->user_id = $data->user_id;
        if(key_exists('last_updated', $data))
            $this->last_updated = $data->last_updated ?? time();
        if(key_exists('created_by', $data))
            $this->created_by = $data->created_by;
        if(key_exists('feature_id', $data))
            $this->feature_id = $data->feature_id;
        
    }

    public function getFeature(){
        $data = DB::table($this->table)
                    ->join('stakeholder_permission_rules', 'stakeholder_permission_rules.id', '=', 'user_holder_permission.permission_id')
                    ->join('stakeholder_permission', 'stakeholder_permission.id', '=', 'stakeholder_permission_rules.permission_id')
                    ->join('stakeholder_feature', 'stakeholder_feature.feature_id', '=', 'stakeholder_permission.feature_id')
                    ->where($this->table . '.user_id', '=', $this->user_id)
                    ->where('stakeholder_feature.parent_id', '=', 0)
                    ->groupBy('stakeholder_feature.feature_id')
                    ->select('stakeholder_feature.*')
                    ->get();

                  
    }

    public function checkPermission()
    {
        $data = DB::table($this->table)
                    ->join('stakeholder_permission_rules', 'stakeholder_permission_rules.id', '=', 'user_holder_permission.permission_id')
                    ->join('stakeholder_permission', 'stakeholder_permission.id', '=', 'stakeholder_permission_rules.permission_id')
                    ->join('stakeholder_feature', 'stakeholder_feature.feature_id', '=', 'stakeholder_permission.feature_id')
                    ->where($this->table . '.user_id', '=', $this->user_id)
                    ->where('stakeholder_feature.feature_id', '=', $this->feature_id)
                    ->select('stakeholder_permission.*')
                    ->get()->toArray();
        
        return $data;
       
    }

    static function defaultData($username = 'developer'){
        $userModel = new UsersModel();

        $userModel->username = $username;

        $userModel->findOne('username')->chain(['rules']);
        $userModel = $userModel->get_attribute();
        $permissionRulesList = DB::table('stakeholder_permission_rules')->where('rules_id', $userModel->rules_id)->get();
        
        foreach ($permissionRulesList as $key => $value) {
            $permissionData = [
                'permission_id' => $value->permission_id,
                'user_id' => $userModel->user_id,
                'last_updated' => time(),
                'created_by' => 'system'
            ];
            UserHolderPermissionModel::create($permissionData);
        }
        
    }
}