<?php

namespace App\Http\Controllers\api;

use App\Models\StoreModel;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDestroy;
use App\Http\Requests\StoreRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
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
    public function store(StoreRequest $request)
    {
        $storeModel = new StoreModel;
        $storeModel->set_data($request->all());
        
        $data['created_at'] = time();
        $data['last_updated'] = time();
        $data['created_by'] = auth()->user()->user_id();
        $data['logo_url'] = "";


        $uploadedDir = 'store';
        if($request->file('logo') != null){
            $path = $request->file('logo')->store($uploadedDir, 'public');
            $data['logo_url'] = Storage::disk('public')->url($path);
        }

        $storeModel->set_data($data);
        
        $stored = $storeModel->create();

       
        if($stored){
            $storeModel->show()->byId()->chain(['owner']);
            $store = $storeModel->get_data();
            return response_ok($store , 'store is created!');
        }else{
            return bad_request('failed create store!!');
        }
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StoreModel  $storeModel
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $storeModel = new StoreModel;

        $data['user_id'] = auth()->user()->user_id();

        $storeModel->set_data($data);

        $data = $storeModel->byOwner()->getAll()->include(['owner', 'creator'])->run();

        return response_ok($data , 'successfully retrieving data!!');
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StoreModel  $storeModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        var_dump($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StoreModel  $storeModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(StoreDestroy $storeDestroy)
    {
        $storeModel = new StoreModel;
        $storeModel->set_data($storeDestroy->all());

        $data = $storeModel->deleteOne()->byId();
        return response_ok($data , 'store is deleted!');
    }
}