<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\UsersModel;
use Illuminate\Http\Request;

class UsersController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UsersModel  $usersModel
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $usersModel = new UsersModel;
        $usersModel->set_data($request->all());
        $users = $usersModel->show();
        
        return response_ok('successfully retreving data', $users);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UsersModel  $usersModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UsersModel $usersModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UsersModel  $usersModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(UsersModel $usersModel)
    {
        //
    }
}