<?php

namespace App\Http\Controllers\api;

use App\Models\UsersModel;
use Illuminate\Http\Request;
use App\Models\StakeholderFeat;
use App\Http\Controllers\Controller;
use App\Http\Requests\HolderFeatDetail;

class HolderFeatController extends Controller
{
    public function show()
    {

        $holderFeat = new StakeholderFeat(['user_id' => auth()->user()->user_id()]);

        $allFeat = $holderFeat->findAll();

        return response_ok($allFeat, 'successfully retrieving data!!');
    }

    public function holderFeat(Request $request)
    {
        $userModel = new UsersModel;
        $userModel->set_data(['user_id' => auth()->user()->user_id()]);

        $users = $userModel->findOne('user_id')->chain(['rules', 'user_info', 'device', 'features']);
        $data = $users = (array) $users->get_attribute();
        return response_ok($data, 'successfully inserting data!!');
    }

    public function detail(HolderFeatDetail $request)
    {
        if (!$request->get('feature_id')) {
            return bad_request('feature_id is required!!');
        }

        $holderFeat = new StakeholderFeat(['feature_id' => $request->get('feature_id'), 'user_id' => auth()->user()->user_id()]);
        $holderFeat->findOneByFeatId();

        $data = $holderFeat->get_attribute();

        return response_ok($data, 'successfully retrieving data!!');
    }
}