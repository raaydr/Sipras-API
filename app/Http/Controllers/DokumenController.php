<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\User;
use Auth;
use Redirect;
use DataTables;
use DateTime;
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

class DokumenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function dokumenEdit()
    {
        $title = 'Welcome Admin';
        
        return view('master.dataDokumen',);
    }

    public function searchUnit(Request $request){

        $search = $request->search;

        if($search == ''){
           $dokumens = User::where('level', 0)->orderby('name','asc')->select('name',)->limit(10)->get();
        }else{
           $dokumens = User::where('level', 0)->orderby('name','asc')->select('name')->where('name', 'like', '%' .$search . '%')->orWhere('nama_barang', 'like', '%' .$search . '%')->limit(10)->get();
        }
  
        $response = array();
        foreach($dokumens as $dokumen){
        $response[] = array("value"=>$dokumen->name);
        }
  
        return response()->json($response);
     
    }
    public function tabelDokumen(Request $request)
    {
        
        $data = Dokumen::where('status', '!=',0)->orderBy('created_at', 'desc')->get();
            if($request->ajax()){
    
                return datatables()->of($data)                   
                    ->addIndexColumn()
                    ->addColumn('tanggal', function($row){
                        
                        $tanggal_mulai = $row->terbit;
                        $tanggal_mulai=Carbon::parse($tanggal_mulai)->isoFormat('D MMMM Y');
    
                        return $tanggal_mulai;
                        
                    })
                    ->addColumn('konten', function($row){

                        $status = $row->tipe_konten;
                        switch ($status) {
                            case '2':
                                $b = $row->link_dokumen;
                                
                                $asset= "/dokumen/";
                                $detail=  $asset.$b;
                                
                                $image = '<a href="'.$detail.'"  target="_blank" class="btn btn-outline-warning">File</a>';
                                return $image;
                                break;
                            case '1':
                                $url_konten = $row->link_dokumen;
                                $actionBtn =' <a href="'.$url_konten.'"  target="_blank" class="btn btn-outline-info">Link</a>';
                                return $actionBtn;
                                break;
                                default:
                                echo "stikes medistra";
                                break;
                        } 
                        
                        
                            
                    })
                    ->addColumn('berlaku', function($row){
                        $kadaluarsa = $row->kadaluarsa;
                        $now = Carbon::now(); // today
        
                        if($kadaluarsa == NULL){
                            return '<p class="text-success"> berlaku</p>';
                        }else{
                            if ($now <= $kadaluarsa ) {
                                return '<p class="text-success"> berlaku</p>';
                            } else {
                                return '<p class="text-danger">tidak berlaku</p>';
                                
                            }    
                        }
                        
        
                    })
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
                        $judul = $row->judul;
                        $nomor = $row->nomor;
                        $unit = $row->unit;
                        $terbit = $row->terbit;
                        $kadaluarsa = $row->kadaluarsa;
                        $kategori = $row->kategori;
                        $tipe_konten = $row->tipe_konten;
                        $link_dokumen = $row->link_dokumen;
                        $actionBtn ='
                        <a class="btn btn-outline-primary m-2" data-toggle="modal" data-myid="'.$id.'" 
                        data-judul="'.$judul.'"
                        data-nomor="'.$nomor.'"
                        data-unit="'.$unit.'"
                        data-terbit="'.$terbit.'"  
                        data-kadaluarsa="'.$kadaluarsa.'"  
                        data-kategori="'.$kategori.'"  
                        data-tipe_konten="'.$tipe_konten.'"
                        data-url_konten="'.$link_dokumen.'"
                        
                        
                        data-target="#modal-edit-konten"  target="_blank">
                        edit</a>
                        ';
                        $actionBtn =$actionBtn.' <a data-id="'.$id.'" class="btn btn-outline-success m-1 publishDokumen">Publish</a>';
                        $actionBtn =$actionBtn.' 
                            <a id="hapus" data-toggle="modal" data-target="#upload-dokumen'.$id.'" class="btn btn-outline-danger m-1">Hapus</a></dl>
                                                            <div class="modal fade" id="upload-dokumen'.$id.'">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content bg-danger">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Penolakan</h4>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">    
                                                                                <p>Apa anda yakin ingin menghapus Dokumen '.$judul.' ini ?</p>
                                                                                <div class="modal-footer justify-content-between">
                                                                                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                                                                <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$id.'" data-dismiss="modal" data-original-title="Delete" class="btn btn-outline-light deleteDokumen">Delete</a>
                                                                                </div>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            <!-- /.modal -->';
                        
                        
                        
                        return $actionBtn;
                    })->rawColumns(['tanggal','konten','berlaku','status','action'])
                    ->make(true);
            }
    }

    public function dokumenUpdate(Request $request){
        $validator = Validator::make($request->all(), 
        [   
            
            'judul' => 'required|string',
            'nomor' => 'nullable|string',
            'kategori' => 'nullable|string',
            'search_unit' => 'nullable|string',
            'terbit' => 'required|date',
            'kadaluarsa' => 'nullable|date',
            
            'url_konten' => 'nullable|string',
            
        ],

        $messages = 
        [
            
            'judul.required' => 'judul tidak boleh kosong!',
            'terbit.required' => 'tanggal terbit tidak boleh kosong!',            
            'deskripsi.required' => 'deskripsi unit tidak boleh kosong!',
            
        ]);     

        if($validator->fails())
        {
            return response()->json(['status'=>0, 'msg'=>'periksa input','error'=>$validator->errors()->all()]);
        }
        $update = array();

        $id = $request->id;
        $user_id = Auth::user()->id;
        $dokumen="kosong";
        $update['judul'] = $request->judul;
        if($request->nomor != NULL){
            $update['nomor'] = $request->nomor;
        }
        if($request->kategori != NULL){
            $update['kategori'] = $request->kategori;
        }
        

        $update['terbit'] = $request->terbit;
        if($request->kadaluarsa != NULL){
            $update['kadaluarsa'] = $request->kadaluarsa;
        }
        
        if($request->search_unit != NULL){
            $unit = $request->search_unit;
            $update['unit'] = $unit;
        }

        if($request->url_konten != NULL){
            $update['tipe_konten'] = 1;
            $update['link_dokumen'] = $request->url_konten;
            
        }
        $user_id = Auth::user()->id; 
        
        
        
        
        if($request->id != NULL){
            $update['updated_at'] = now(); 
            
            
    
            Dokumen::updateOrInsert(
                ['id' => $id], $update
            );
            File::delete('dokumen/' . $dokumen);
        } else{
                
            $update['unit_id'] = $user_id;
            $update['status'] = 1;
            $update['updated_at'] = now(); 
            $update['created_at'] = now(); 
            Dokumen::updateOrInsert(
                 $update
            );
        }
        return response()->json(['status'=>1,'success'=>'Berhasil Update Dokumen']);
        
    }

    public function dokumenPublish($id)
    {
        
        //$mata_pelatihan_id = Crypt::decrypt($id);
        $val = Dokumen::where('id', $id)->value('status');
        switch ($val) {
            case '1':
                Dokumen::where('id', $id)->update([
                    'status' => 2,
                    'updated_at' => now(),
                    ]
                );
                return response()->json(['success'=>'Batal Publish Dokumen']);
                break;
            case '2':
                Dokumen::where('id', $id)->update([
                    'status' => 1,
                    'updated_at' => now(),
                    ]
                );
                return response()->json(['success'=>'Publish Dokumen']);
                break;
                default:
                echo "stikes medistra";
                break;
        }    
    }

    public function dokumenDelete($id)
    {
        $dokumen = Dokumen::where('id', $id)->value('link_dokumen');
        Dokumen::where('id', $id)->update([
            
            'status' => 0,
            'updated_at' => now(),
            ]
        );
        File::delete('dokumen/' . $dokumen);
        return response()->json(['success'=>'Hapus Dokumen ']);
        
    }
}
