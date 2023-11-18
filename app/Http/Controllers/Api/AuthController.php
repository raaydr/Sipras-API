<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;
use App\Rules\MatchOldPassword;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends BaseController
{
    public function ForgotPassword(Request $request){
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        return $status === Password::RESET_LINK_SENT
            ? $this->sendResponse($status,'Berhasil mengirim link reset')
            : $this->sendError('Unauthorised.', [$status]);
    }

    public function ChangePassword(Request $request)

    {

        $validator = Validator::make($request->all(), 
        [   
            
            
            'current_password' => ['required', new MatchOldPassword],

            'new_password' => ['required','string','min:8','required'],

            'new_confirm_password' => ['same:new_password'],
        ],

        $messages = 
        [
            
                  
            
        ]);  
        if($validator->fails())
        {
            return $this->sendError('periksa input',$validator->errors()->all());
        }
        
   

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

   
        $success = Auth::user();
        return $this->sendResponse($success,'berhasil ubah password');
        //return redirect()->route('admin.listPendaftar');

    }
}
