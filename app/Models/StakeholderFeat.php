<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
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
        $this->feature_icon = $data->feature_icon ?? '';
        
        if(key_exists('last_updated', $data)){
            $this->last_updated = (int) $data->last_updated;
        }else{
            $this->last_updated =  time();
        }
        
        if(key_exists('created_by', $data))
            $this->created_by = $data->created_by;
        if(key_exists('parent_id', $data))
            $this->parent_id = (int) $data->parent_id;

    }

    public function origin_attribute(){
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

    public function generate_key(){

        $featHolder = StakeholderFeat::all()->count();

        $count = ($featHolder + 1);

        $key = 'FEAT/HOLDER' . str_pad($count,4,"0",STR_PAD_LEFT);

        $this->feature_code = $key;
    }

    public function create(){
        $this->generate_key();
        
        DB::table($this->table)->insert(
                (array)$this->origin_attribute()
        );
        $this->findOneByFeatId();
    }

    public function findOneByFeatId(){
        $data = FeatureModel::where('feature_id', $this->feature_id)->first();
        $this->set_data($data);
    }

}