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
    protected $is_checked;

    public function __construct($data = [])
    {
        $this->set_data($data);
    }


    public function set_data($data = [])
    {

        $data = (object) $data;
        if (key_exists('id', $data))
            $this->id = (int) $data->id;
        if (key_exists('feature_id', $data))
            $this->feature_id = (int) $data->feature_id;
        if (key_exists('permission', $data))
            $this->permission = $data->permission;
        if (key_exists('last_updated', $data))
            $this->last_updated = $data->last_updated ?? time();
        if (key_exists('created_by', $data))
            $this->created_by = $data->created_by;
        if (key_exists('is_checked', $data))
            $this->is_checked = $data->is_checked;
    }

    public function originalAtribute()
    {
        $data['id'] = $this->id;
        $data['feature_id'] = $this->feature_id;
        $data['permission'] = $this->permission;
        $data['last_updated'] = $this->last_updated;
        $data['created_by'] = $this->created_by;
        return (object) $data;
    }

    public function attribute()
    {
        $data['id'] = $this->id;
        $data['feature_id'] = $this->feature_id;
        $data['permission'] = $this->permission;
        $data['last_updated'] = $this->last_updated;
        $data['created_by'] = $this->created_by;
        $data['is_checked'] = $this->is_checked;

        return (object) $data;
    }

    public function permissionRules()
    {
        return $this->belongsTo(StakeholderFeat::class, 'id');
    }

    public function getPermission()
    {
        $result = [];
        $data = DB::table('stakeholder_permission_rules')
            ->leftJoin('user_holder_permission', 'user_holder_permission.permission_id', '=', 'stakeholder_permission_rules.id')
            ->join('stakeholder_permission', 'stakeholder_permission.id', '=', 'stakeholder_permission_rules.permission_id')
            ->join('stakeholder_feature', 'stakeholder_feature.feature_id', '=', 'stakeholder_permission.feature_id')
            ->where('stakeholder_permission.feature_id', '=', $this->feature_id)
            // ->groupBy('stakeholder_permission.id')
            ->select('stakeholder_permission.*', DB::raw('CASE WHEN user_holder_permission.permission_id IS NULL THEN 0 ELSE 1 END AS is_checked'))
            ->get()->toArray();

        foreach ($data as $key => $value) {
            $this->set_data($value);
            array_push($result, $this->attribute());
        }
        return $result;
    }

    static function defaultData()
    {
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