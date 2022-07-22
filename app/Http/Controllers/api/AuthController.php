<?php

namespace App\Http\Controllers\api;

use App\Models\AuthModel;
use App\Models\RulesModel;
use App\Models\UserDevice;
use App\Models\UsersModel;
use Illuminate\Http\Request;
use App\Models\UserInfoModel;
use App\Mail\UserVerification;
use App\Http\Controllers\Helper;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRegister;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\UserVerification as Verification;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function __construct()
    {
        
    }

    
    public function index()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRegister $request)
    {

      
        $authModel = new AuthModel;
        $userModel = new UsersModel;
        $userVerificationMail = new UserVerification;

        $code = $userModel->generate_code_verification(6);
        $time = time() + 3600;


        $authModel->set_data($request->all());
        $authModel->set_data(['email_verify_id' => $code, 'email_verify_id_expired' => $time]);
        

        $user = $authModel->create();

        
        $userVerificationMail->username = $user->username;
        $userVerificationMail->code = $code;

        Mail::to($user->email)->send($userVerificationMail);

        return response_ok('Waiting for verification',$user);
    }

    public function verification(Verification $request){
        $userModel = new UsersModel;

        $userModel->set_data($request->all());

        $user = $userModel->show();
        
        $param = $request->all();

        if($user->email_verify_id_expired < time()){
            return bad_request('code has expired!!');
        }

        if($user->email_verify_id == $param['code']){

            $userVerfication = UsersModel::where('user_id', $user->user_id)->get()->first();

            $userVerfication->email_verify_at = time();
            $userVerfication->email_is_verify = 1;
            $userVerfication->is_actived = 1;

            $userVerfication->save();

            $user = $userModel->show();

            return response_ok($user,'successfully verification');
        }else{
            return bad_request('invalid code!!');
        }

        
    }

    public function login(LoginRequest $request)
    {   

        $authModel = new AuthModel;


        $credentials = $request->only('email', 'password');
        $credentials['is_actived'] = 1;

        $authModel->set_data($credentials);

        $rulesModel = new RulesModel;
       

        // $rules = $rulesModel->findOne(['rules_id' => $credentials['rules_id']]);

        try {
            if (! $token = auth()->attempt($credentials)) {
                return bad_request('invalid credentials!');
            }
        } catch (JWTException $e) {
            return bad_request('could not create token!');
        }

      

        $userModel = new UsersModel;
        $userModel->set_data(auth()->user()->attributes());
       
        $users = $userModel->findOne('user_id')->chain(['rules','user_info', 'device', 'features']);

        $users = (array) $users->get_attribute();
       
        $userInfo = UserInfoModel::where('user_id', $users['user_id'])->get()->first();

        if($userInfo){
            $userInfo->user_id = $users['user_id'];
            $userInfo->is_actived = 1;
            $userInfo->active_at = time();
            $userInfo->last_actived = $userInfo['last_actived'];
            $userInfo->save();
        }else{
            $info = new UserInfoModel;
            $info->generate_id();
            $info->user_info_id = $info->get_attribute()->user_info_id;
            $info->user_id = $users['user_id'];
            $info->is_actived = 1;
            $info->active_at = time();
            $info->last_actived = time();
            $info->save();
        }
        
        $deviceModel = new UserDevice;

        $deviceModel->set_data($request->all());
        $deviceModel->set_data(['user_id' => $users['user_id'], 'last_updated' => time()]);
        
        $deviceData = UserDevice::where('user_id', $users['user_id'])->get()->first();
       
        if($deviceData){
            $deviceData->user_id = $users['user_id'];
            $deviceData->lang = $deviceModel->lang ?? $deviceData['lang'];
            $deviceData->platform = $deviceModel->platform ?? $deviceData->platform;
            $deviceData->version = (int) $deviceModel->version;
            $deviceData->name = $deviceModel->name ?? $deviceData->name;
            $deviceData->identifier = $deviceModel->identifier ?? $deviceData->identifier;
            $deviceData->fcm_token = $deviceModel->fcm_token ?? $deviceData->fcm_token;
            $deviceData->last_updated = time();

            $deviceData->save();
        }else{
            $deviceModel->generate_id();
            $deviceModel->create();
        }


        $users['token'] = $token;

        return response_ok($users, 'successfully loggedIn!!');
    }

    public function logout()
    {
        $users = auth_data()->attributes();

        $userInfo = UserInfoModel::where('user_id', $users['user_id'])->get()->first();
        
        $last_actived = $userInfo->active_at;

        $userInfo->is_actived = 0;
        $userInfo->active_at = 0;
        $userInfo->last_actived = $last_actived;

        $userInfo->save();

        auth_logout();


        return response_ok([], 'successfully logged out!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AuthModel  $authModel
     * @return \Illuminate\Http\Response
     */
    public function show(AuthModel $authModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AuthModel  $authModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuthModel $authModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AuthModel  $authModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuthModel $authModel)
    {
        //
    }

    public function guard()
    {
        return Auth::guard();
    }

    public function auth_rules($rules){
        switch ($rules->name) {
            case 'owner':
                return auth('owner-api');
                break;
            
            default:
                 return auth('owner-api');
                break;
        }
    }


}