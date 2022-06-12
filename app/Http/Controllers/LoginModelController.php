<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoginModelRequest;
use App\Http\Requests\UpdateLoginModelRequest;
use App\Models\LoginModel;

class LoginModelController extends Controller
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
     * @param  \App\Http\Requests\StoreLoginModelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLoginModelRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoginModel  $loginModel
     * @return \Illuminate\Http\Response
     */
    public function show(LoginModel $loginModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LoginModel  $loginModel
     * @return \Illuminate\Http\Response
     */
    public function edit(LoginModel $loginModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLoginModelRequest  $request
     * @param  \App\Models\LoginModel  $loginModel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLoginModelRequest $request, LoginModel $loginModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoginModel  $loginModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(LoginModel $loginModel)
    {
        //
    }
}
