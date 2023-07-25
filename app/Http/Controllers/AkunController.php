<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Redirect;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;

class AkunController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function PembuatanAdmin()
    {
        $title = 'Welcome Admin';
        
        return view('master.dataBarang',);
    }
    public function DaftarAdmin(Request $request)
    {

        $validator = Validator::make($request->all(), 
        [   
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',

        ],

        $messages = 
        [
            'name.required' => 'Nama tidak boleh kosong!',
            'email.required' => 'E-Mail tidak boleh kosong !',
            'password.required' => 'Password tidak boleh kosong',
            
        ]);     

        if($validator->fails())
        {
        return back()->withErrors($validator)->withInput();  
        }
        
        //Table Users
        $user = new User;
        $user->name =   $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->level = 1;
        $user->save();

        return redirect()->route('admin.create.fasil')->with('success', 'Registrasi Anda telah berhasil!. Silakan login dengan menggunakan email dan password Anda.');
    }
}
