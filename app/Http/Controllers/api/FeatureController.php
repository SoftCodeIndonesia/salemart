<?php

namespace App\Http\Controllers\api;

use App\Models\FeatureModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreFeatureModelRequest;

class FeatureController extends Controller
{
    public function store(StoreFeatureModelRequest $request){
        $featureModel = new FeatureModel();

        $featureModel->set_data($request->all());
        $featureModel->set_data(['created_by' => auth()->user()->user_id()]);

        $uploadedDir = 'features';
        if($request->file('feature_icon_mobile') != null){
            $path = $request->file('feature_icon_mobile')->store($uploadedDir, 'public');
            $data['feature_icon_mobile'] = Storage::disk('public')->url($path);
        }
        if($request->file('feature_icon_web') != null){
            $path = $request->file('feature_icon_web')->store($uploadedDir, 'public');
            $data['feature_icon_web'] = Storage::disk('public')->url($path);
        }
        if($request->file('feature_icon_desktop') != null){
            $path = $request->file('feature_icon_desktop')->store($uploadedDir, 'public');
            $data['feature_icon_desktop'] = Storage::disk('public')->url($path);
        }

        if(isset($data)){
            $featureModel->set_data($data);
        }
        
     
        $featureModel->create();

        $data = $featureModel->origin_attribute();

        if($data->feature_id){
            return response_ok($data , 'successfully inserting data!!');
        }else{
            return bad_request('something when wrong!!');
        }
    }

    public function show(){
        $featureModel = new FeatureModel();

        $features = $featureModel->findAll();

        return response_ok($features , 'successfully retrieving data!!');
    }
}