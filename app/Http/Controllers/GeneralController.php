<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Auth;
use Redirect;
use DataTables;
use DateTime;
use Carbon\Carbon;

class GeneralController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function ubah_password(){
        $title = 'ubah password';
        
        

        //return view('admin.ubahpassword', compact('title'));
    }

    public function change_password(Request $request)

    {

        $request->validate([

            'current_password' => ['required', new MatchOldPassword],

            'new_password' => ['required'],

            'new_confirm_password' => ['same:new_password'],

        ]);

   

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

   
        //return redirect()->route('admin.ubah.password')->with('berhasil', 'berhasil ubah password');
        //return redirect()->route('admin.listPendaftar');

    }
}
