<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        

        $level = Auth::user()->level;
        switch ($level) {
            case '0':
                $now = Carbon::now(); // today
                $date = Carbon::parse($now)->isoFormat('D MMMM Y');
                return view('master.welcome', compact('date'));
                break;
            case '1':
                $now = Carbon::now(); // today
                $date = Carbon::parse($now)->isoFormat('D MMMM Y');
                return view('master.welcome', compact('date'));
                break;   
            case '2':
                return view('master.nonAktif');
                break;
            case '3':
                default:
                echo "STIKES MEDISTRA INDONESIA";
                break;
        }        
    
    }
}
