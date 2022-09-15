<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserHolderPermissionModel;
use App\Http\Requests\UserHolderPermissionRequest;
use Illuminate\Support\Facades\Redis;

class UserHolderPermissionController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userHolderPermissionModel = new UserHolderPermissionModel([]);

        foreach (json_decode($request->get('uncheck')) as $key => $value) {
            $userHolderPermissionModel->set_data(['permission_id' => $value]);
            $userHolderPermissionModel->deleteById();
        }

        $result = [];
        foreach (json_decode($request->get('permissions')) as $key => $value) {
            $data['permission_id'] = $value;
            $data['user_id'] = $request->get('user_id');
            $data['created_by'] = auth()->user()->user_id();
            $data['last_updated'] = $request->get('created_at');

            $userHolderPermissionModel->set_data($data);
            $permission = $userHolderPermissionModel->create();
            array_push($result, (array) $permission);
        }
        return response_ok($result, 'Success inserting permission!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}