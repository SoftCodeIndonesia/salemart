<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\RulesModel;
use Illuminate\Http\Request;

class RulesController extends Controller
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
        $rulesModel = new RulesModel;

        $rulesModel->create();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RulesModel  $rulesModel
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $rulesModel = new RulesModel;

        $rules = $rulesModel->findAll();

        return response_ok($rules , 'successfully retrieving data!!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RulesModel  $rulesModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RulesModel $rulesModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RulesModel  $rulesModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(RulesModel $rulesModel)
    {
        //
    }
}