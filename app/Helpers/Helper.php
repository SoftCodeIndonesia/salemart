<?php

use App\Models\AuthModel;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\App;

    if(!function_exists('bad_request')){
        function bad_request($message = 'something when wrong!'){
            return response()->json([
                'status' => false,
                'message' => $message,
            ], 400);
        }
    }
    if(!function_exists('response_ok')){
        function response_ok($payload = [],$message = 'successfully'){
            return response()->json([
                'status' => true,
                'message' => $message,
                'payload' => $payload,
            ], 200);
        }
    }

    if(!function_exists('auth_data')){
        function auth_data()
        {
           
            $authData = [];

            if(auth('owner-api')->user() != null){
                $authData = auth('owner-api')->user();
            }

            return $authData;
        }
    }
    if(!function_exists('auth_logout')){
        function auth_logout()
        {
            auth('owner-api')->logout(true);
        }
    }