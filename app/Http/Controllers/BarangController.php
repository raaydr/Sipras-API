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

    public function BarangEdit()
    {
        $title = 'Welcome Admin';
        
        return view('master.dataBarang',);
    }

    public function BarangDetail($id)
    {
        $title = 'Welcome Admin';
        $barang = Barang::where('id',$id)->first();
        return view('master.detailBarang',compact('barang'));
    }


    public function BarangUpdate(Request $request){
        $validator = Validator::make($request->all(), 
        [   
            
            'nama_barang' => 'required|string',
            'kode_barang' => 'nullable|string|unique:barang,kode_barang',
            'tipe_barang' => 'nullable|string',
            'satuan_barang' => 'nullable|string',
            'keterangan' => 'required',
        ],

        $messages = 
        [
            
            'nama_barang.required' => 'nama barang tidak boleh kosong!',
            'kode_barang.required' => 'kode barang tidak boleh kosong!',
            'kode_barang.unique' => 'kode barang tidak boleh sama',            
            'tipe_barang.required' => 'tipe barang unit tidak boleh kosong!',
            'satuan_barang.required' => 'satuan barang tidak boleh kosong!',
            'keterangan.required' => 'keterangan barang tidak boleh kosong!',
            
        ]);     

        if($validator->fails())
        {
            return response()->json(['status'=>0, 'msg'=>'periksa input','error'=>$validator->errors()->all()]);
        }
        $update = array();

        $id = $request->id;
        if($request->nama_barang != NULL){
            $update['nama_barang'] = $request->nama_barang;
        }
        if($request->kode_barang != NULL){
            $update['kode_barang'] = $request->kode_barang;
        }
        if($request->tipe_barang != NULL){
            $update['tipe_barang'] = $request->tipe_barang;
        }
        if($request->satuan_barang != NULL){
            $update['satuan_barang'] = $request->satuan_barang;
        }
        if($request->keterangan != NULL){
            $update['keterangan'] = $request->keterangan;;
        }
        if($request->id != NULL){
            $update['updated_at'] = now(); 
            $user_id = Auth::user()->id;        
            $user_name = Auth::user()->name;
            $level = Auth::user()->level;
            $update['editedBy_id'] = $user_id;      
            $update['editedBy_name'] = $user_name;    
            $data = Barang::where('id', $id)->value('user_id');
            if ($level == 0){
                Barang::updateOrInsert(
                    ['id' => $id], $update
                );
            } else{
                if($data != $user_id){
                    return response()->json(['status'=>2,'error'=>'Anda tidak bisa mengubah Barang ini']);
                } else{
                    Barang::updateOrInsert(
                        ['id' => $id], $update
                    );
                }
            }            
        } else{
            
            $barang = new Barang;
            $barang->nama_barang =  $update['nama_barang'];
            $barang->kode_barang =  $update['kode_barang'];
            $barang->tipe_barang =  $update['tipe_barang'];
            $barang->satuan_barang =  $update['satuan_barang'];
            $barang->keterangan =  $update['keterangan'];
            $barang->status =  1;
            $barang->jumlah =  0;
            $user_id = Auth::user()->id;
            $user_name = Auth::user()->name;
            $barang->user_id =  $user_id;
            $barang->user_name =  $user_name;
            $barang->editedBy_id =  $user_id;
            $barang->editedBy_name =  $user_name;
            $barang->save();
            
        }
        return response()->json(['status'=>1,'success'=>'Berhasil Update Dokumen']);
        
    }


    public function tabelBarang(Request $request)
    {
        
        $data = Barang::where('status', '!=',0)->orderBy('created_at', 'desc')->get();
            if($request->ajax()){
    
                return datatables()->of($data)                   
                    ->addIndexColumn()
                    ->addColumn('jumlahbarang', function($row){
                        $jumlah = $row->jumlah;
                        $satuan = $row->satuan_barang;
                        
                        return $jumlah.' '.$satuan;
                    }) 
                    ->addColumn('status', function($row){
                        $status = $row->status;
                        switch ($status) {
                            case '2':
                                return '<p class="text-danger">Tidak Aktif</p>';
                                break;
                            case '1':
                                return '<p class="text-success">Aktif</p>';     
                                break;
                                default:
                                echo "stikes medistra";
                                break;
                        } 
                    }) 
                    ->addColumn('action', function($row){
                        $userID = Auth::user()->id;
                        $level = Auth::user()->level;
                        $id = $row->id;
                        $nama = $row->nama_barang;
                        $detail = route('BarangDetail',$id); 
                        $actionBtn = '<a class="btn btn-outline-primary m-1" href='.$detail.'>detail</a>';
                        $status = $row->status;
                        $user_id = $row->user_id;
                        if ($level == 0){
                            switch ($status) {
                                case '2':
                                    $actionBtn =$actionBtn.' <a data-id="'.$id.'" class="btn btn-outline-success m-1 publishBarang">Kembalikan</a>';
                                    break;
                                case '1':
                                    $actionBtn =$actionBtn.' 
                                    <a id="hapus" data-toggle="modal" data-target="#hapus-barang'.$id.'" class="btn btn-outline-danger m-1">Hapus</a></dl>
                                                                <div class="modal fade" id="hapus-barang'.$id.'">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content bg-danger">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">Penolakan</h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">    
                                                                                    <p>Apa anda yakin ingin menghapus Barang '.$nama.' ini ?</p>
                                                                                    <div class="modal-footer justify-content-between">
                                                                                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                                                                    <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$id.'" data-dismiss="modal" data-original-title="Delete" class="btn btn-outline-light publishBarang">Delete</a>
                                                                                    </div>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                        <!-- /.modal-content -->
                                                                    </div>
                                                                    <!-- /.modal-dialog -->
                                                                </div>
                                                                <!-- /.modal -->';
                             
                                    break;
                                    default:
                                    echo "stikes medistra";
                                    break;
                            
                                }
                        } else{
                            if($user_id == $userID){
                                switch ($status) {
                                    case '2':
                                        $actionBtn =$actionBtn.' <a data-id="'.$id.'" class="btn btn-outline-success m-1 publishBarang">Kembalikan</a>';
                                        break;
                                    case '1':
                                        $actionBtn =$actionBtn.' 
                                        <a id="hapus" data-toggle="modal" data-target="#hapus-barang'.$id.'" class="btn btn-outline-danger m-1">Hapus</a></dl>
                                                                    <div class="modal fade" id="hapus-barang'.$id.'">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content bg-danger">
                                                                                <div class="modal-header">
                                                                                    <h4 class="modal-title">Penolakan</h4>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">    
                                                                                        <p>Apa anda yakin ingin menghapus Barang '.$nama.' ini ?</p>
                                                                                        <div class="modal-footer justify-content-between">
                                                                                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                                                                        <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$id.'" data-dismiss="modal" data-original-title="Delete" class="btn btn-outline-light publishBarang">Delete</a>
                                                                                        </div>
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                            <!-- /.modal-content -->
                                                                        </div>
                                                                        <!-- /.modal-dialog -->
                                                                    </div>
                                                                    <!-- /.modal -->';
                                 
                                        break;
                                        default:
                                        echo "stikes medistra";
                                        break;
                                
                                    }
                            }
                        }
                        
                        
                        
                        
                        return $actionBtn;
                    })->rawColumns(['jumlahbarang','status','action'])
                    ->make(true);
            }
    }

    
    public function BarangPublish($id)
    {
        
        //$mata_pelatihan_id = Crypt::decrypt($id);
        $userID = Auth::user()->id;
        $userLevel = Auth::user()->level;
        $dataUser = Barang::where('id', $id)->value('user_id');
    
        switch ($userLevel){
            case '0':
                $val = Barang::where('id', $id)->value('status');
             switch ($val) {
                case '1':
                    Barang::where('id', $id)->update([
                        'status' => 2,
                        'updated_at' => now(),
                        ]
                    );
                    return response()->json(['status'=>1,'success'=>'Batal Publish Barang']);
                    break;
                case '2':
                    Barang::where('id', $id)->update([
                        'status' => 1,
                        'updated_at' => now(),
                        ]
                    );
                    return response()->json(['status'=>1,'success'=>' Publish Barang']);
                    break;
                    default:
                    echo "stikes medistra";
                    break;
            }    
                break;
            case '1':
                if($userID == $dataUser){
                    $val = Barang::where('id', $id)->value('status');
            switch ($val) {
                case '1':
                    Barang::where('id', $id)->update([
                        'status' => 2,
                        'updated_at' => now(),
                        ]
                    );
                    return response()->json(['status'=>1,'success'=>' Batal Publish Barang']);
                    break;
                case '2':
                    Barang::where('id', $id)->update([
                        'status' => 1,
                        'updated_at' => now(),
                        ]
                    );
                    return response()->json(['status'=>1,'success'=>' Publish Barang']);
                    break;
                    default:
                    echo "stikes medistra";
                    break;
            }    
                }else{
                    return response()->json(['error'=>'Anda Tidak bisa mengubah']);
                }
                break;
            case '2':
                return response()->json(['status'=>0,'error'=>' Anda tidak bisa mengubah ini']);
                break;
                default:
                echo "stikes medistra";
                break;
        }
        
      
    }

    public function BarangDelete($id)
    {
        
        Barang::where('id', $id)->update([
            
            'status' => 2,
            'updated_at' => now(),
            ]
        );
        
        return response()->json(['success'=>'Hapus Barang ']);
        
    }
}
