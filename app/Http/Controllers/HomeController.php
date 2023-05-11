<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

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
                return view('home');
                break;
            case '1':
                return view('register');
                break;
            case '2':
                return view('welcome');
                break;
                echo "stikes";
                break;
        }        
        
    }
}
