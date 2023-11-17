<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;



class LoginController extends BaseController
{
    public function Login(Request $request)
    {
        
      

        if (($request->loginAttempts) >=3 ) {
            
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'loginAttempts' => 'required',
                'recaptchaValue' => 'required|captcha',
                
                
            ]);
        } else{
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                
                
            ]);
        }
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            
            
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 

        else{ 
             

            $success['token'] =  $user->createToken("User Login")->plainTextToken;

            $success['name'] =  $user->name;
            //return $user->createToken("User Login")->plainTextToken;
            return $this->sendResponse($success, 'User login successfully.');
        } 
       
    }

    public function Logout(Request $request)
    {
        $user = Auth::user();
        $request->user()->currentAccessToken()->delete();
        return $this->sendResponse($user->name, $user->name .' berhasil logout');
    }

    public function IdentifyUser(Request $request)
    {
        $success = Auth::user();
        return $this->sendResponse($success, 'User login successfully.');
        //return response()->json(Auth::user());
    }
}
