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
class PerlengkapanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function PerlengkapanEdit()
    {
        $title = 'Welcome Admin';
        
        
        return view('master.dataPerlengkapan',);
    }

    public function PerlengkapanDetail($id)
    {
        $title = 'Welcome Admin';
        $perlengkapan = Perlengkapan::where('id',$id)->first();
        $barang = Barang::where('id',$perlengkapan->barang_id)->first();
        $harga_perlengkapan= $perlengkapan->harga_perlengkapan;
        return view('master.detailPerlengkapan',compact('barang','perlengkapan','harga_perlengkapan'));
    }

    Public function PageQrcodePerlengkapan($id){
        $perlengkapan_id = $id;
        $perlengkapan = Perlengkapan::where('id',$perlengkapan_id)->first();
        $barang = Barang::where('id',$perlengkapan->barang_id)->first();
        
        
        
        return view('master.qrcodePerlengkapan',compact('perlengkapan','barang'));
    }
    public function PerlengkapanQrcode($id){
        $perlengkapan = Perlengkapan::where('id',$id)->first();
        $qrpage = route('PageQrcodePerlengkapan', $id);
        $kode = $perlengkapan->kode_perlengkapan;
        $image = QrCode::format('png')
        ->merge('/public/stikes/stikes.png')
        ->size(300)
        ->errorCorrection('H')
        ->generate($qrpage);

        return response($image)->header('Content-type','image/png');
    }

    public function searchBarang(Request $request){

        $search = $request->search;

        if($search == ''){
           $barangs = Barang::where('status', 1)->orderby('nama_barang','asc')->select('id','nama_barang','kode_barang',)->limit(10)->get();
        }else{
           $barangs = Barang::where('status', 1)->orderby('nama_barang','asc')->select('id','nama_barang','kode_barang',)->where('nama_barang', 'like', '%' .$search . '%')->limit(10)->get();
        }
  
        $response = array();
        foreach($barangs as $barang){
            $response[] = array("id"=>$barang->id,"label"=>$barang->nama_barang,"value"=>$barang->kode_barang);
        }
  
        return response()->json($response);
     
    }

    public function PerlengkapanUpdate(Request $request){
        $validator = Validator::make($request->all(), 
        [   
            
            'jumlah_perlengkapan' => 'required|string',
            'harga_perlengkapan' => 'nullable',
            'keterangan_perlengkapan' => 'required',
            'tanggal_pembelian' => 'required|date',
            'lokasi_perlengkapan' => 'required|string',
            'departemen' => 'required|string',
            'kondisi_perlengkapan' => 'required',
            'leandable_perlengkapan' => 'required',
            'foto_perlengkapan' => 'nullable',
            'foto_perlengkapan' => 'image|mimes:jpeg,png,jpg|max:5120',
            

        ],

        $messages = 
        [
            
            'jumlah_perlengkapan.required' => 'jumlah Perlengkapan tidak boleh kosong!',
            
            'keterangan_perlengkapan.unique' => 'keterangan  Perlengkapan tidak boleh sama',            
            'tanggal_pembelian.required' => 'tanggal pembelian Perlengkapan unit tidak boleh kosong!',

            'lokasi_perlengkapan.required' => 'lokasi Perlengkapan tidak boleh kosong!',
            'departemen.required' => 'departemen Perlengkapan tidak boleh kosong!',
            'kondisi_perlengkapan.required' => 'kondisi perlengkapan tidak boleh kosong!',
            'leandable_perlengkapan.required' => 'Status peminjaman Perlengkapan tidak boleh kosong!',
            
            //'foto_perlengkapan.required' => 'Foto Perlengkapan tidak boleh kosong!',
            'foto_perlengkapan.mimes' => 'foto harus format jpeg,jpg,png!',
            'foto_perlengkapan.max' => 'file harus dibawah 5 mb !',
        ]);     

        if($validator->fails())
        {
            return response()->json(['status'=>0, 'msg'=>'periksa input','error'=>$validator->errors()->all()]);
        }
        $update = array();

        $id = $request->id;
        $barang_id = $request->barang_id;
        $kode = $request->kode;
        if($request->jumlah_perlengkapan != NULL){
            $update['jumlah_perlengkapan'] = $request->jumlah_perlengkapan;
        }
        if($request->harga_perlengkapan != NULL){
            $harga_str = preg_replace("/[^0-9]/", "", $request->harga_perlengkapan);
            $harga_perlengkapan = (int) $harga_str;
            $update['harga_perlengkapan'] = $harga_perlengkapan;
        }
        if($request->keterangan_perlengkapan != NULL){
            $update['keterangan_perlengkapan'] = $request->keterangan_perlengkapan;
        }
        
        if($request->tanggal_pembelian != NULL){
            $update['tanggal_pembelian'] = $request->tanggal_pembelian;
        }
        if($request->lokasi_perlengkapan != NULL){
            $update['lokasi_perlengkapan'] = $request->lokasi_perlengkapan;
        }
        if($request->departemen != NULL){
            $update['departemen'] = $request->departemen;
        }
        if($request->kondisi_perlengkapan != NULL){
            $update['kondisi_perlengkapan'] = $request->kondisi_perlengkapan;
        }
        if($request->leandable_perlengkapan != NULL){
            $update['leandable_perlengkapan'] = $request->leandable_perlengkapan;
        }

        if($request->foto_perlengkapan != NULL){
            $delete_gambar = Perlengkapan::where('id', $id)->value('foto_perlengkapan');
            $delete_thumbnail = Perlengkapan::where('id', $id)->value('foto_perlengkapan_thumbnail');    
            $image = $request->file('foto_perlengkapan');
            $imageThumbnail = Image::make($image);
            $imageName = $image->getClientOriginalName();
            $namaFile = $kode.'_'.time();
            $namaFileRILL = $namaFile.'.'.$image->getClientOriginalExtension();
            $namaFileRILL = preg_replace("/\s+/", "", $namaFileRILL);
            $destinationPath = public_path().'/foto-perlengkapan/' ;
            $image->move($destinationPath,$namaFileRILL);

            $namaFileFake = $namaFile.'_thumbnail'.'.'.$image->getClientOriginalExtension();
            $namaFileFake = preg_replace("/\s+/", "", $namaFileFake);
            $destinationPathFake = public_path().'/foto-perlengkapan/' ;
            $imageThumbnail->save($destinationPath . $namaFileRILL, 20);
            
            $imageThumbnail->resize(200,200, function($constraint)
            {
                $constraint->aspectRatio();
            });
            $imageThumbnail->save($destinationPathFake . $namaFileFake, 20);
            $update['foto_perlengkapan'] = $namaFileRILL;
            $update['foto_perlengkapan_thumbnail'] = $namaFileFake;
        
        }
        if($request->id != NULL){
            $update['updated_at'] = now(); 
            $user_id = Auth::user()->id;        
            $user_name = Auth::user()->name;
            $level = Auth::user()->level;
            $update['editedBy_id'] = $user_id;      
            $update['editedBy_name'] = $user_name;
            $data = Barang::where('id', $id)->value('user_id');    
            $file = Perlengkapan::where('id', $id)->value('foto_perlengkapan');
            $thumbnail = Perlengkapan::where('id', $id)->value('foto_perlengkapan_thumbnail');
            if (($level == 0)||($data == $user_id)){
                Perlengkapan::updateOrInsert(
                    ['id' => $id], $update
                );
                if($request->foto_perlengkapan != NULL){

                
                    
                    File::delete('foto-perlengkapan/' . $file);
                    File::delete('foto-perlengkapan/' . $thumbnail);
                    
                    
                }
                $jumlah_barang = Perlengkapan::where('barang_id', $barang_id)->where('status', 1)->where('kondisi_perlengkapan','!=',3)->sum('jumlah_perlengkapan');

                $barang['jumlah'] = $jumlah_barang; 
                Barang::updateOrInsert(
                    ['id' => $barang_id], $barang
                );
                
                
            
                return response()->json(['status'=>1,'success'=>'Berhasil Update Perlengkapan']);
            } else{
                return response()->json(['status'=>2,'error'=>'Anda tidak bisa mengubah Perlengkapan ini']);
            }  
            
            
            
            
        } else{
            
            $update['barang_id'] = $barang_id;
            $update['kode_perlengkapan'] = "kosong";
            $update['barcode_perlengkapan'] = "kosong";
            $update['status'] = 1;
            $update['status_peminjaman'] = 0;
            $user_id = Auth::user()->id;        
            $user_name = Auth::user()->name;  
            $update['user_id'] = $user_id;      
            $update['user_name'] = $user_name;
            //$update['updated_at'] = now(); 
            //$update['created_at'] = now(); 
            //Perlengkapan::updateOrInsert($update);

            $perlengkapan = new Perlengkapan;
            $perlengkapan->jumlah_perlengkapan=$update['jumlah_perlengkapan'];
            $perlengkapan->harga_perlengkapan=$update['harga_perlengkapan'];
            $perlengkapan->keterangan_perlengkapan=$update['keterangan_perlengkapan'];
            $perlengkapan->tanggal_pembelian=$update['tanggal_pembelian'];
            $perlengkapan->lokasi_perlengkapan=$update['lokasi_perlengkapan'];
            $perlengkapan->departemen=$update['departemen'];
            $perlengkapan->kondisi_perlengkapan=$update['kondisi_perlengkapan'];
            $perlengkapan->leandable_perlengkapan=$update['leandable_perlengkapan'];
            if($request->foto_perlengkapan != NULL){
                $perlengkapan->foto_perlengkapan=$update['foto_perlengkapan'];
                $perlengkapan->foto_perlengkapan_thumbnail=$update['foto_perlengkapan_thumbnail'];
            }
           
            $perlengkapan->barang_id=$barang_id;
            $perlengkapan->kode_perlengkapan="kosong";
            $perlengkapan->barcode_perlengkapan="kosong";
            $perlengkapan->status=1;
            $perlengkapan->status_peminjaman=0;
            $perlengkapan->user_id=$user_id;
            $perlengkapan->user_name=$user_name;
            $perlengkapan->editedBy_id=$user_id;
            $perlengkapan->editedBy_name=$user_name;
            $perlengkapan->save();

            //ngebuat kode perlengkapan secara otomatis dengan urutan id
            $perlengkapan_id = $perlengkapan->id;
            $kode = $request->kode;
            $kode = $kode.'-'.$perlengkapan_id;
            $kode_barang['kode_perlengkapan'] = $kode; 
            Perlengkapan::updateOrInsert(
                ['id' => $perlengkapan_id], $kode_barang
            );

            //Ngebuat jumlah barang nambah kalau kondisinya gk rusak
            
            $jumlah_barang = Perlengkapan::where('barang_id', $barang_id)->where('status', 1)->where('kondisi_perlengkapan','!=',3)->sum('jumlah_perlengkapan');

            $barang['jumlah'] = $jumlah_barang; 
            Barang::updateOrInsert(
                ['id' => $barang_id], $barang
            );
            
            
        
            return response()->json(['status'=>1,'success'=>'Berhasil Update Perlengkapan']);

        }

        //Ngebuat jumlah barang nambah kalau kondisinya gk rusak
        
          
        
    }


    public function tabelPerlengkapan(Request $request)
    {
        $data = Perlengkapan::join('barang', 'barang.id', '=', 'perlengkapan.barang_id')
                    ->where('perlengkapan.status', 1)->orderBy('perlengkapan.updated_at', 'desc')->get();

        $data = DB::table('perlengkapan')->where('perlengkapan.status',1)
        ->join('barang', 'barang.id', '=', 'perlengkapan.barang_id')
        ->select('barang.nama_barang','barang.satuan_barang','barang.tipe_barang', 'perlengkapan.foto_perlengkapan', 'perlengkapan.foto_perlengkapan_thumbnail', 
        'perlengkapan.kondisi_perlengkapan', 'perlengkapan.status', 'perlengkapan.user_id', 'perlengkapan.kode_perlengkapan', 'perlengkapan.jumlah_perlengkapan', 'perlengkapan.updated_at', 
        'perlengkapan.lokasi_perlengkapan','perlengkapan.departemen','perlengkapan.user_name','perlengkapan.tanggal_pembelian','perlengkapan.keterangan_perlengkapan','perlengkapan.editedBy_name','perlengkapan.id','perlengkapan.barang_id')
        ->orderBy('perlengkapan.updated_at', 'desc')->get();
        
        //$data = Perlengkapan::where('status', 1)->orderBy('status', 'asc')->orderBy('created_at', 'desc')->get();
            if($request->ajax()){
    
                return datatables()->of($data)                   
                    ->addIndexColumn()
                    ->addColumn('image', function($row){



                        $b = $row->foto_perlengkapan;
                        $c = $row->foto_perlengkapan_thumbnail;
                        if( $b != NULL){
                            $asset= "/foto-perlengkapan/";
                            $detail=  $asset.$b;
                            $assetThumbnail= "/foto-perlengkapan/";
                            $thumbnail=  $assetThumbnail.$c;
                            $id = $row->id;
                            $image = '<div class="col-md-8"> <a href='.$detail.' data-toggle="lightbox" >
                            <img src='.$thumbnail.' class="img-fluid" alt="white sample"/>
                            </a> </div>';
                        } else{
                            $asset= "/stikes/stikes.png";
                            $detail=  $asset;
                            $assetThumbnail= "/stikes/stikes.png";
                            $thumbnail=  $assetThumbnail;
                            $id = $row->id;
                            $image = '<div class="col-md-8"> <a href='.$detail.' data-toggle="lightbox" >
                            <img src='.$thumbnail.' class="img-fluid" alt="white sample"/>
                            </a> </div>';
                        }
                       
                        
                            return $image;
                    }) 
                    ->addColumn('kondisi', function($row){
                        $status = $row->kondisi_perlengkapan;
                        switch ($status) {
                            
                            case '1':
                                return '<p class="text-success">Bagus</p>';     
                                break;
                            case '2':
                                return '<p class="text-warning">Kurang Bagus</p>';
                                break;
                            case '3':
                                return '<p class="text-danger">Rusak</p>';
                                break;
                                default:
                                echo "stikes medistra";
                                break;
                        } 
                    })
                    ->addColumn('Jumlah', function($row){
                        $jumlah = $row->jumlah_perlengkapan;
                        $piece = $row->satuan_barang;
                        return $jumlah.' '.$piece;   
                    })
                    ->addColumn('tanggal', function($row){
                        $terakhir = $row->tanggal_pembelian;
                        $tanggal_akhir=Carbon::parse($terakhir)->isoFormat('D MMMM Y');
                        return $tanggal_akhir;
                    })  
                    ->addColumn('action', function($row){
                        $userID = Auth::user()->id;
                        $level = Auth::user()->level;
                        $user_id = $row->user_id;
                        $id = $row->id;
                        $nama = $row->kode_perlengkapan;
                        $qrcode = route('PerlengkapanQrcode',$id); 
                        $actionBtn = '<a class="btn btn-outline-info m-1" href='.$qrcode.' target="_blank">QRcode</a>';
                        $detail = route('PerlengkapanDetail',$id); 
                        $actionBtn =$actionBtn. '<a class="btn btn-outline-primary m-1" href='.$detail.'>detail</a>';
                        $qrpage = route('PageQrcodePerlengkapan', $id); 
                        $actionBtn =$actionBtn. '<a class="btn btn-outline-warning m-1" href='.$qrpage.' target="_blank">qrpage</a>';
                        $status = $row->status;
                        if ($level == 0){
                            switch ($status) {
                                case '2':
                                    $actionBtn =$actionBtn.' <a data-id="'.$id.'" class="btn btn-outline-success m-1 publishPerlengkapan">Kembalikan</a>';
                                    break;
                                case '1':
                                    $actionBtn =$actionBtn.' 
                                    <a id="hapus" data-toggle="modal" data-target="#hapus-Perlengkapan'.$id.'" class="btn btn-outline-danger m-1">Hapus</a></dl>
                                                                <div class="modal fade" id="hapus-Perlengkapan'.$id.'">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content bg-danger">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">Penolakan</h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">    
                                                                                    <p>Apa anda yakin ingin menghapus Perlengkapan '.$nama.' ini ?</p>
                                                                                    <div class="modal-footer justify-content-between">
                                                                                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                                                                    <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$id.'" data-dismiss="modal" data-original-title="Delete" class="btn btn-outline-light deletePerlengkapan">Delete</a>
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
                        }else{
                            if($user_id == $userID){
                                switch ($status) {
                                    
        
                                case '2':
                                    $actionBtn =$actionBtn.' <a data-id="'.$id.'" class="btn btn-outline-success m-1 publishPerlengkapan">Kembalikan</a>';
                                    break;
                                case '1':
                                    $actionBtn =$actionBtn.' 
                                    <a id="hapus" data-toggle="modal" data-target="#hapus-Perlengkapan'.$id.'" class="btn btn-outline-danger m-1">Hapus</a></dl>
                                                                <div class="modal fade" id="hapus-Perlengkapan'.$id.'">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content bg-danger">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">Penolakan</h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">    
                                                                                    <p>Apa anda yakin ingin menghapus Perlengkapan '.$nama.' ini ?</p>
                                                                                    <div class="modal-footer justify-content-between">
                                                                                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                                                                    <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$id.'" data-dismiss="modal" data-original-title="Delete" class="btn btn-outline-light deletePerlengkapan">Delete</a>
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
                    })->rawColumns(['image','kondisi','Jumlah','tanggal','action'])
                    ->make(true);
            }
    }

    public function tabelPerlengkapanBarang(Request $request, $id)
    {
        
        $data = Perlengkapan::where('barang_id', $id)->where('status', 1)->orderBy('status', 'asc')->orderBy('created_at', 'desc')->get();
            if($request->ajax()){
    
                return datatables()->of($data)                   
                    ->addIndexColumn()
                    ->addColumn('image', function($row){
                        $b = $row->foto_perlengkapan;
                        $c = $row->foto_perlengkapan_thumbnail;
                        if( $b != NULL){
                            $asset= "/foto-perlengkapan/";
                            $detail=  $asset.$b;
                            $assetThumbnail= "/foto-perlengkapan/";
                            $thumbnail=  $assetThumbnail.$c;
                            $id = $row->id;
                            $image = '<div class="col-md-8"> <a href='.$detail.' data-toggle="lightbox" >
                            <img src='.$thumbnail.' class="img-fluid" alt="white sample"/>
                            </a> </div>';
                        } else{
                            $asset= "/stikes/stikes.png";
                            $detail=  $asset;
                            $assetThumbnail= "/stikes/stikes.png";
                            $thumbnail=  $assetThumbnail;
                            $id = $row->id;
                            $image = '<div class="col-md-8"> <a href='.$detail.' data-toggle="lightbox" >
                            <img src='.$thumbnail.' class="img-fluid" alt="white sample"/>
                            </a> </div>';
                        }
                       
                        
                            return $image;
                    }) 
                    ->addColumn('kondisi', function($row){
                        $status = $row->kondisi_perlengkapan;
                        switch ($status) {
                            
                            case '1':
                                return '<p class="text-success">Bagus</p>';     
                                break;
                            case '2':
                                return '<p class="text-warning">Kurang Bagus</p>';
                                break;
                            case '3':
                                return '<p class="text-danger">Rusak</p>';
                                break;
                                default:
                                echo "stikes medistra";
                                break;
                        } 
                    })
                    ->addColumn('status', function($row){
                        $status = $row->status;
                        switch ($status) {
                            
                            case '1':
                                return '<p class="text-success">aktif</p>';     
                                break;
                            case '2':
                                return '<p class="text-danger">Dihapus</p>';
                                break;
                                default:
                                echo "stikes medistra";
                                break;
                        } 
                    })  
                    ->addColumn('action', function($row){
                        $userID = Auth::user()->id;
                        $level = Auth::user()->level;
                        $user_id = $row->user_id;
                        $id = $row->id;
                        $nama = $row->nama_perlengkapan;
                        $qrcode = route('PerlengkapanQrcode',$id); 
                        $actionBtn = '<a class="btn btn-outline-info m-1" href='.$qrcode.' target="_blank">QRcode</a>';
                        $detail = route('PerlengkapanDetail',$id); 
                        $actionBtn =$actionBtn. '<a class="btn btn-outline-primary m-1" href='.$detail.'>detail</a>';
                        $qrpage = route('PageQrcodePerlengkapan', $id); 
                        $actionBtn =$actionBtn. '<a class="btn btn-outline-warning m-1" href='.$qrpage.' target="_blank">qrpage</a>';
                        $status = $row->status;
                        if ($level == 0){
                            switch ($status) {
                                case '2':
                                    $actionBtn =$actionBtn.' <a data-id="'.$id.'" class="btn btn-outline-success m-1 publishPerlengkapan">Kembalikan</a>';
                                    break;
                                case '1':
                                    $actionBtn =$actionBtn.' 
                                    <a id="hapus" data-toggle="modal" data-target="#hapus-Perlengkapan'.$id.'" class="btn btn-outline-danger m-1">Hapus</a></dl>
                                                                <div class="modal fade" id="hapus-Perlengkapan'.$id.'">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content bg-danger">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">Penolakan</h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">    
                                                                                    <p>Apa anda yakin ingin menghapus Perlengkapan '.$nama.' ini ?</p>
                                                                                    <div class="modal-footer justify-content-between">
                                                                                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                                                                    <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$id.'" data-dismiss="modal" data-original-title="Delete" class="btn btn-outline-light deletePerlengkapan">Delete</a>
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
                        }else{
                            if($user_id == $userID){
                                switch ($status) {
                                    
        
                                case '2':
                                    $actionBtn =$actionBtn.' <a data-id="'.$id.'" class="btn btn-outline-success m-1 publishPerlengkapan">Kembalikan</a>';
                                    break;
                                case '1':
                                    $actionBtn =$actionBtn.' 
                                    <a id="hapus" data-toggle="modal" data-target="#hapus-Perlengkapan'.$id.'" class="btn btn-outline-danger m-1">Hapus</a></dl>
                                                                <div class="modal fade" id="hapus-Perlengkapan'.$id.'">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content bg-danger">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">Penolakan</h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">    
                                                                                    <p>Apa anda yakin ingin menghapus Perlengkapan '.$nama.' ini ?</p>
                                                                                    <div class="modal-footer justify-content-between">
                                                                                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                                                                    <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$id.'" data-dismiss="modal" data-original-title="Delete" class="btn btn-outline-light deletePerlengkapan">Delete</a>
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
                    })->rawColumns(['image','kondisi','status','action'])
                    ->make(true);
            }
    }
    public function PerlengkapanPublish($id)
    {
        
        //$mata_pelatihan_id = Crypt::decrypt($id);
        $val = Perlengkapan::where('id', $id)->value('status');
        $barang_id = Perlengkapan::where('id', $id)->value('barang_id');
        switch ($val) {
            case '1':
                Perlengkapan::where('id', $id)->update([
                    'status' => 2,
                    'updated_at' => now(),
                    ]
                );
                //Ngebuat jumlah barang nambah kalau kondisinya gk rusak
        
                $jumlah_barang = Perlengkapan::where('barang_id', $barang_id)->where('status', 1)->where('kondisi_perlengkapan','!=',3)->sum('jumlah_perlengkapan');

                Barang::where('id', $barang_id)->update([
                    'jumlah' => $jumlah_barang,
                    'updated_at' => now(),
                    ]
                );
               
                return response()->json(['success'=>'Batal Publish Perlengkapan']);
                break;
            case '2':
                Perlengkapan::where('id', $id)->update([
                    'status' => 1,
                    'updated_at' => now(),
                    ]
                );
                
        
                //Ngebuat jumlah barang nambah kalau kondisinya gk rusak
        
                $jumlah_barang = Perlengkapan::where('barang_id', $barang_id)->where('status', 1)->where('kondisi_perlengkapan','!=',3)->sum('jumlah_perlengkapan');

                Barang::where('id', $barang_id)->update([
                    'jumlah' => $jumlah_barang,
                    'updated_at' => now(),
                    ]
                ); 
                return response()->json(['success'=>'Publish Perlengkapan']);
                break;
                default:
                echo "stikes medistra";
                break;
        }
        
    }

    public function PerlengkapanDelete($id)
    {
        $barang_id = Perlengkapan::where('id', $id)->value('barang_id');
        Perlengkapan::where('id', $id)->update([
            
            'status' => 2,
            'updated_at' => now(),
            ]
        );
         
        $file = Perlengkapan::where('id', $id)->value('foto_perlengkapan');
        $thumbnail = Perlengkapan::where('id', $id)->value('foto_perlengkapan_thumbnail');
        File::delete('foto-perlengkapan/' . $file);
        File::delete('foto-perlengkapan/' . $thumbnail);
        
        //Ngebuat jumlah barang nambah kalau kondisinya gk rusak
        
        $jumlah_barang = Perlengkapan::where('barang_id', $barang_id)->where('status', 1)->where('kondisi_perlengkapan','!=',3)->sum('jumlah_perlengkapan');
        Barang::where('id', $barang_id)->update([
            'jumlah' => $jumlah_barang,
            'updated_at' => now(),
            ]
        );
        return response()->json(['success'=>'Hapus Perlengkapan ']);
        
    }
}
