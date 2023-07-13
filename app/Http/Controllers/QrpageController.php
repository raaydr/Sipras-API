<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Perlengkapan;
use Auth;
use Redirect;
use DataTables;
use Image;
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
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrpageController extends Controller
{
    Public function PageQrcodePerlengkapan($id){
        $perlengkapan_id = $id;
        $perlengkapan = Perlengkapan::where('id',$perlengkapan_id)->first();
        $barang = Barang::where('id',$perlengkapan->barang_id)->first();
        
        
        
        return view('master.qrcodePerlengkapan',compact('perlengkapan','barang'));
    }
}
