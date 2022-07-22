<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Models\StakeholderFeat;
use App\Http\Controllers\Controller;

class HolderFeatController extends Controller
{
    public function show()
    {
        $holderFeat = new StakeholderFeat();

        $allFeat = $holderFeat->findAll();

        return response_ok($allFeat , 'successfully retrieving data!!');
    }
}