<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryDelete;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryEditRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  
    public function store(CategoryRequest $request)
    {
        // var_dump($request->all());
        // die;
        $categoryModel = new CategoryModel;
        $categoryModel->set_data($request->all());
        $categoryModel->set_data(['created_at' => time(), 'created_by' => auth_data()->user_id()]);
        $categoryModel->generate_id();
        
        $create = CategoryModel::create((array) $categoryModel->get_attribute());

        $categoryModel->set_data($create);

        $category = $categoryModel->get_attribute();

        if(!empty($category)){
            return response_ok($category, 'successfully inserting category!!');
        }else{
            return bad_request('failed inserting category');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategoryModel  $categoryModel
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $categoryModel = new CategoryModel;
        $data = $categoryModel->show();

        return response_ok($data, 'successfully retrieving category!!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategoryModel  $categoryModel
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryEditRequest $request)
    {
        $categoryModel = CategoryModel::where('category_id', $request->get('category_id'))->update(['category_name' => $request->get('category_name')]);

        $category = new CategoryModel;

        $data = $category->show(['category_id' => $request->get('category_id')]);

        return response_ok($data, 'successfully editing category!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryModel  $categoryModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryDelete $request)
    {
        $id = $request->get('category_id');
        $deleted = CategoryModel::where('category_id', $id)->delete();

        if($deleted){
            return response_ok([], 'successfully deleting category!!');
        }else{
            return bad_request('failed deleting category!!');
        }
    }
}