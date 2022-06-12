<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryModel extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'category_name';
    // protected $keyType = 'string';
    public $timestamps = false;

    protected $cateogry_id;
    protected $category_name;
    protected $created_at;
    protected $created_by;

    public $fillable = ['category_id', 'category_name', 'created_at', 'created_by'];

    public function set_data($data = [])
    {
        $data = (object) $data;

        if(key_exists('category_id', $data))
            $this->category_id = $data->category_id;
     

        if(key_exists('category_name', $data))
            $this->category_name = $data->category_name;
     

        if(key_exists('created_at', $data))
            $this->created_at = (int) $data->created_at;
     

        if(key_exists('created_by', $data))
            $this->created_by = $data->created_by;
     
        
        
    }

    public function generate_id()
    {
        $rules_all = CategoryModel::all()->count();

        $key = time() . ($rules_all + 1);

        $id = Hash::make($key);
        
        $data['category_id'] = $id;
        $this->set_data($data);
    }

    public function get_attribute()
    {
        $data['category_id'] = $this->category_id;
        $data['category_name'] = $this->category_name;
        $data['created_at'] = $this->created_at;
        $data['created_by'] = $this->created_by;
       
        return (object) $data;
    }


    public function creator(){
        return $this->hasOne(UsersModel::class, 'user_id', 'created_by');
    }

    public function show($cond = [])
    {
        $data;
        
        if(empty($cond)){
            
            $categories = CategoryModel::all();
            // var_dump($categories);
            // die;
            $categoryData = [];

            foreach ($categories as $key => $value) {
                $this->set_data($value->attributes);
                array_push($categoryData, $this->get_attribute());
            }

            $data = $categoryData;
        }else{
            $categories = $categories = CategoryModel::where($cond)->get();
            $categoryData = [];
            if(count($categories) == 1){
                $this->set_data($categories->first()->attributes);
                $data = $this->get_attribute();
            }else{
                foreach ($categories as $key => $value) {
                    $this->set_data($value->attributes);
                    array_push($categoryData, $this->get_attribute());
                }

                $data = $categoryData;
            }
            
        }

        return $data;
    }
}