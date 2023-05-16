<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
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

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dataBarang()
    {
        $title = 'Welcome Admin';
        
        return view('master.dataBarang',);
    }

    public function tabelBarang(Request $request)
    {
        
        $data = Dokumen::where('status', '!=',0)->orderBy('created_at', 'desc')->get();
            if($request->ajax()){
    
                return datatables()->of($data)                   
                    ->addIndexColumn()
                    ->addColumn('status', function($row){
                        $status = $row->status;
                        switch ($status) {
                            case '2':
                                return '<p class="text-warning">Belum Dipublish</p>';
                                break;
                            case '1':
                                return '<p class="text-success">Sudah Dipublish</p>';     
                                break;
                                default:
                                echo "stikes medistra";
                                break;
                        } 
                    }) 
                    ->addColumn('action', function($row){
                        $id = $row->id;
                        $detail = route('barangDetail',$id); 
                        $actionBtn = '<a class="btn btn-outline-success m-1" href='.$detail.'>detail</a>';
                    })->rawColumns(['status','action'])
                    ->make(true);
            }
    }

    public function detailBarang($id)
    {
        $title = 'Welcome Admin';
        
        return view('master.detailBarang',);
    }
}
