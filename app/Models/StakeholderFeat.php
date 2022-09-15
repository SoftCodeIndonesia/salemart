<?php

namespace App\Models;

use stdClass;
use Illuminate\Support\Facades\DB;
use App\Models\PermissionRulesModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StakeholderFeat extends Model
{
    use HasFactory;

    protected $primaryKey = 'feature_id';
    protected $table = 'stakeholder_feature';
    public $timestamps = false;

    protected $feature_id;
    protected $feature_code;
    protected $feature_name;
    protected $feature_route;
    protected $feature_description;
    protected $feature_icon;
    protected $last_updated;
    protected $created_by;
    protected $parent_id;
    protected $children;
    protected $creator;
    protected $permissions;


    protected $user_id;

    public function __construct($data = [])
    {
        $this->set_data($data);
    }

    public function set_data($data = [])
    {

        $data = (object) $data;

        if (key_exists('user_id', $data))
            $this->user_id = $data->user_id;

        if (key_exists('feature_id', $data))
            $this->feature_id = $data->feature_id;

        if (key_exists('feature_code', $data))
            $this->feature_code = (string) $data->feature_code;

        if (key_exists('feature_route', $data))
            $this->feature_route = (string) $data->feature_route;

        if (key_exists('feature_name', $data))
            $this->feature_name = $data->feature_name;

        $this->feature_description = $data->feature_description ?? '';
        $this->feature_icon = $data->feature_icon ?? '';

        if (key_exists('last_updated', $data)) {
            $this->last_updated = (int) $data->last_updated;
        } else {
            $this->last_updated =  time();
        }

        if (key_exists('created_by', $data)) {
            $this->created_by = $data->created_by;

            if ($data->created_by !== 'system') {
                $userModel = new UsersModel();

                $userModel->set_data(['user_id' => $data->created_by]);

                $user = $userModel->findOne('user_id')->chain(['rules']);

                $this->creator = $user;
            } else {
                $this->creator = new stdClass();
            }
        }

        if (key_exists('parent_id', $data)) {
            $this->parent_id = (int) $data->parent_id;

            if ($this->parent_id == 0) {
                $this->children = $this->getChildren();
            } else {
                $this->children = [];
            }
        }

        $this->permission = $data->permission ?? [];
    }

    public function origin_attribute()
    {
        $data['feature_id'] = $this->feature_id;
        $data['feature_code'] = $this->feature_code;
        $data['feature_name'] = $this->feature_name;
        $data['feature_route'] = $this->feature_route;
        $data['feature_description'] = $this->feature_description;
        $data['feature_icon'] = $this->feature_icon;
        $data['last_updated'] = $this->last_updated;
        $data['created_by'] = $this->created_by;
        $data['parent_id'] = $this->parent_id ?? 0;
        return (object) $data;
    }

    public function get_attribute()
    {
        $data['feature_id'] = $this->feature_id;
        $data['feature_code'] = $this->feature_code;
        $data['feature_name'] = $this->feature_name;
        $data['feature_route'] = $this->feature_route;
        $data['feature_description'] = $this->feature_description;
        $data['feature_icon'] = $this->feature_icon;
        $data['last_updated'] = $this->last_updated;
        $data['created_by'] = $this->created_by;
        $data['parent_id'] = $this->parent_id ?? 0;
        $data['children'] = $this->children;
        $data['creator'] = $this->creator;
        $data['permission'] = $this->permission;
        return (object) $data;
    }

    public function generate_key()
    {

        $featHolder = StakeholderFeat::all()->count();

        $count = ($featHolder + 1);

        $key = 'FEAT/HOLDER' . str_pad($count, 4, "0", STR_PAD_LEFT);

        $this->feature_code = $key;
    }

    public function findAll()
    {
        $data = DB::table($this->table)->get()->toArray();

        $features = [];

        foreach ($data as $key => $value) {
            $value = (object) $value;

            $permission = new PermissionHolderModel(['feature_id' => $value->feature_id]);
            $permission = $permission->getPermission();

            $value->permission = $permission;

            $this->set_data($value);

            array_push($features, $this->get_attribute());
        }
        return $features;
    }

    public function findAllWithTree()
    {

        $data = DB::table($this->table)
            ->join('stakeholder_permission', 'stakeholder_permission.feature_id', '=', $this->table . '.feature_id')
            ->join('stakeholder_permission_rules', 'stakeholder_permission_rules.permission_id', '=', 'stakeholder_permission.id')
            ->join('user_holder_permission', 'user_holder_permission.permission_id', '=', 'stakeholder_permission.id')
            ->where('user_holder_permission.user_id', $this->user_id)
            ->where($this->table . '.parent_id', 0)
            ->groupBy('stakeholder_feature.feature_id')
            ->select('stakeholder_feature.*')
            ->get()->toArray();

        $features = [];

        foreach ($data as $key => $value) {
            $value = (object) $value;

            $permission = new UserHolderPermissionModel(['user_id' => $this->user_id, 'feature_id' => $value->feature_id]);
            $permission = $permission->checkPermission();
            $value->permission = $permission;

            $this->set_data($value);
            array_push($features, $this->get_attribute());
        }
        return $features;
    }

    public function getChildren()
    {
        $child = new StakeholderFeat();

        $feat = StakeholderFeat::where('parent_id', $this->feature_id)->get()->toArray();

        $children = [];

        foreach ($feat as $key => $value) {


            $value = (object) $value;
            $permission = new UserHolderPermissionModel(['user_id' => $this->user_id, 'feature_id' => $value->feature_id]);

            $isGranted = $permission->checkPermission();


            if ($isGranted) {

                $value->permission = $isGranted;

                $child->set_data($value);
                array_push($children, $child->get_attribute());
            }
        }



        return $children;
    }

    public function create()
    {

        $this->generate_key();

        $id = DB::table($this->table)->insert(
            (array)$this->origin_attribute()
        );
        // var_dump($id);
        $this->findOneByFeatId();
    }

    public function findOneByFeatId()
    {
        $data = DB::table($this->table)->where('feature_id', $this->feature_id)->first();

        $permission = new UserHolderPermissionModel(['user_id' => $this->user_id, 'feature_id' => $data->feature_id]);
        $permission = $permission->getPermission();
        $data->permission = $permission;

        $this->set_data($data);
    }


    public function feature()
    {
        return $this->belongsTo(PermissionRulesModel::class, 'feature_id');
    }
}