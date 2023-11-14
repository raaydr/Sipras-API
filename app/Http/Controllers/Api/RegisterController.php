<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class RegisterController extends BaseController
{
    public function register (Request $request){
        $validator = Validator::make($request->all(), 
        [   
            'name' => 'required|string|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            
            
            

        ],

        $messages = 
        [
            'name.required' => 'Username harus diisi, ya!',
            'email.required' => 'Email harus diisi, ya!',
            'password.required' => 'Kata sandi harus diisi dan diingat, ya!',
            'name.unique' => 'Username sudah dipakai.',
            'email.unique' => 'Email sudah dipakai.',
            'password.confirmed' => 'Kata sandi tidak cocok/salah!',
           
        ]);     

        if($validator->fails())
        {
            return $this->sendError('periksa input',$validator->errors()->all());
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->level = 2;
        $user->save();
        $success['name'] =  $user->name;
            //return $user->createToken("User Login")->plainTextToken;
        return $this->sendResponse($success, 'User login successfully.');
    }
}
