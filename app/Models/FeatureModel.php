<?php

namespace App\Models;

use App\Models\UsersModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeatureModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'feature_id';
    protected $table = 'features';
    public $timestamps = false;


    protected $feature_id;
    protected $feature_code;
    protected $feature_name;
    protected $feature_route;
    protected $feature_description;
    protected $feature_icon_web;
    protected $feature_icon_desktop;
    protected $feature_icon_mobile;
    protected $last_updated;
    protected $created_by;
    protected $parent_id;
    protected $children;
    protected $creator;


    public function set_data($data = []){
            
            $data = (object) $data;
            if(key_exists('feature_id', $data))
                $this->feature_id = (string) $data->feature_id;

            if(key_exists('feature_code', $data))
                $this->feature_code = (string) $data->feature_code;

            if(key_exists('feature_route', $data))
                $this->feature_route = (string) $data->feature_route;

            if(key_exists('feature_name', $data))
                $this->feature_name = $data->feature_name;
                
            $this->feature_description = $data->feature_description ?? '';
            $this->feature_icon_web = $data->feature_icon_web ?? '';
            $this->feature_icon_desktop = $data->feature_icon_desktop ?? '';
            $this->feature_icon_mobile = $data->feature_icon_mobile ?? '';
            
            if(key_exists('last_updated', $data)){
                $this->last_updated = (int) $data->last_updated;
            }else{
                $this->last_updated =  time();
            }
            if(key_exists('created_by', $data)){
                $this->created_by = $data->created_by;

                $user = new UsersModel();
                $user->set_data(['user_id' => $data->created_by]);
                $this->creator = (array) $user->show();

            }
                
            if(key_exists('parent_id', $data)){
                if(empty($data->parent_id)){
                    $this->children = $this->getChild();
                }else{
                    $this->parent_id = $data->parent_id;
                }
            }
            
                
    }

    public function single(){
        $data = DB::table($this->table)
            ->where('feature_id', $this->feature_id)
            ->first();
        $this->set_data($data);
        return $this->get_data();
    }

    public function origin_attribute(){
        $data['feature_id'] = $this->feature_id;
        $data['feature_code'] = $this->feature_code;
        $data['feature_name'] = $this->feature_name;
        $data['feature_route'] = $this->feature_route;
        $data['feature_description'] = $this->feature_description;
        $data['feature_icon_web'] = $this->feature_icon_web;
        $data['feature_icon_desktop'] = $this->feature_icon_desktop;
        $data['feature_icon_mobile'] = $this->feature_icon_mobile;
        $data['last_updated'] = $this->last_updated;
        $data['created_by'] = $this->created_by;
        $data['parent_id'] = $this->parent_id ?? '';
        return (object) $data;
    }


    public function get_data(){
        $data['feature_id'] = $this->feature_id;
        $data['feature_name'] = $this->feature_name;
        $data['feature_code'] = $this->feature_code;
        $data['feature_description'] = $this->feature_description;
        $data['feature_icon_web'] = $this->feature_icon_web;
        $data['feature_icon_desktop'] = $this->feature_icon_desktop;
        $data['feature_icon_mobile'] = $this->feature_icon_mobile;
        $data['last_updated'] = $this->last_updated;
        $data['created_by'] = $this->created_by;
        $data['parent_id'] = $this->parent_id ?? '';
        $data['children'] = $this->children ?? [];
        $data['creator'] = $this->creator;
        return (object) $data;
    }

    private function generate_id(){
        $rules_all = FeatureModel::all()->count();

        $key = time() . ($rules_all + 1);

        $this->feature_id = Hash::make($key);
    }
    private function generate_key(){

        $rules_all = FeatureModel::all()->count();

        $count = ($rules_all + 1);

        $key = 'FEAT/' . str_pad($count,4,"0",STR_PAD_LEFT);

        $this->feature_code = $key;
    }
    
    public function create(){
        $this->generate_id();
        $this->generate_key();
        
        DB::table($this->table)->insert(
                (array)$this->origin_attribute()
        );
        $this->findOne();
    }

    public function findOne(){
        $data = FeatureModel::where('feature_id', $this->feature_id)->first();
        $this->set_data($data);
    }

    public function findAll(){
        $data = DB::table($this->table)->where('parent_id', '')->get();

        $menu = [];

        foreach ($data as $key => $value) {
            $this->set_data($value);
            array_push($menu, $this->get_data());
        }

        return $menu;
    }

    private function getChild() {
        $child = new FeatureModel();

        $data = DB::table($this->table)->where('parent_id', $this->feature_id)->get();

        $children = [];

        foreach ($data as $key => $value) {
            $child->set_data($value);
            array_push($children, $child->get_data());
        }

        return $children;
    }
}