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

    public function PerlengkapanEdit($id)
    {
        $title = 'Welcome Admin';
        $barang = Barang::where('id',$id)->first();
        
        return view('master.dataPerlengkapan',compact('barang'));
    }

    public function PerlengkapanDetail($id)
    {
        $title = 'Welcome Admin';
        $image = QrCode::format('png')
        ->merge('/public/stikes/stikes.png')
        ->size(200)
        ->errorCorrection('H')
        ->generate('A simple example of QR code!'.$title);

return response($image)->header('Content-type','image/png');
    }

    public function PerlengkapanQrcode($id){
        $perlengkapan = Perlengkapan::where('id',$id)->first();
        
        $kode = $perlengkapan->kode_perlengkapan;
        $image = QrCode::format('png')
        ->merge('/public/stikes/stikes.png')
        ->size(200)
        ->errorCorrection('H')
        ->generate($kode);

return response($image)->header('Content-type','image/png');
    }

    public function PerlengkapanUpdate(Request $request){
        $validator = Validator::make($request->all(), 
        [   
            
            'jumlah_perlengkapan' => 'required|string',
            'harga_perlengkapan' => 'required',
            'keterangan_perlengkapan' => 'required',
            'tanggal_pembelian' => 'required|date',
            'lokasi_perlengkapan' => 'required|string',
            'departemen' => 'required|string',
            'kondisi_perlengkapan' => 'required',
            'leandable_perlengkapan' => 'required',
            'foto_perlengkapan' => 'required',
            'foto_perlengkapan' => 'image|mimes:jpeg,png,jpg|max:5120',
            

        ],

        $messages = 
        [
            
            'jumlah_perlengkapan.required' => 'jumlah Perlengkapan tidak boleh kosong!',
            'harga_perlengkapan.required' => 'harga Perlengkapan tidak boleh kosong!',
            'keterangan_perlengkapan.unique' => 'keterangan  Perlengkapan tidak boleh sama',            
            'tanggal_pembelian.required' => 'tanggal pembelian Perlengkapan unit tidak boleh kosong!',

            'lokasi_perlengkapan.required' => 'lokasi Perlengkapan tidak boleh kosong!',
            'departemen.required' => 'departemen Perlengkapan tidak boleh kosong!',
            'kondisi_perlengkapan.required' => 'kondisi perlengkapan tidak boleh kosong!',
            'leandable_perlengkapan.required' => 'Status peminjaman Perlengkapan tidak boleh kosong!',
            
            'foto_perlengkapan.required' => 'Foto Perlengkapan tidak boleh kosong!',
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


                
            $imageThumbnail->resize(255,255, function($constraint)
                {
                    $constraint->aspectRatio();
                });
            $namaFileFake = $namaFile.'_thumbnail'.'.'.$image->getClientOriginalExtension();
            $namaFileFake = preg_replace("/\s+/", "", $namaFileFake);
            $destinationPathFake = public_path().'/foto-perlengkapan/' ;
            $imageThumbnail->save($destinationPathFake . $namaFileFake, 30);
            $update['foto_perlengkapan'] = $namaFileRILL;
            $update['foto_perlengkapan_thumbnail'] = $namaFileFake;
        
        }
        if($request->id != NULL){
            $update['updated_at'] = now(); 
            
            
    
            Perlengkapan::updateOrInsert(
                ['id' => $id], $update
            );
            
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
            $perlengkapan->foto_perlengkapan=$update['foto_perlengkapan'];
            $perlengkapan->foto_perlengkapan_thumbnail=$update['foto_perlengkapan_thumbnail'];
            $perlengkapan->barang_id=$barang_id;
            $perlengkapan->kode_perlengkapan="kosong";
            $perlengkapan->barcode_perlengkapan="kosong";
            $perlengkapan->status=1;
            $perlengkapan->status_peminjaman=0;
            $perlengkapan->user_id=$user_id;
            $perlengkapan->user_name=$user_name;
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
            if($update['kondisi_perlengkapan'] != 3){
                $jumlah = Barang::where('id', $barang_id)->value('jumlah');
                $jumlah = $jumlah + $update['jumlah_perlengkapan'];

                $barang['jumlah'] = $jumlah; 
                Barang::updateOrInsert(
                    ['id' => $barang_id], $barang
                );
                return response()->json(['status'=>2,'success'=>'Berhasil Update Barang Bagus','jumlah'=>$jumlah]);
                
            }
            

        }
        return response()->json(['status'=>1,'success'=>'Berhasil Update Barang']);
        
    }


    public function tabelPerlengkapan(Request $request)
    {
        
        $data = Perlengkapan::where('status', '!=',0)->orderBy('created_at', 'desc')->get();
            if($request->ajax()){
    
                return datatables()->of($data)                   
                    ->addIndexColumn()
                    ->addColumn('image', function($row){
                        $b = $row->foto_perlengkapan;
                        $c = $row->foto_perlengkapan_thumbnail;
                        $asset= "/foto-perlengkapan/";
                        $detail=  $asset.$b;
                        $assetThumbnail= "/foto-perlengkapan/";
                        $thumbnail=  $assetThumbnail.$c;
                        $id = $row->id;
                        $image = '<div class="col-md-8"> <a href='.$detail.' data-toggle="lightbox" >
                        <img src='.$thumbnail.' class="img-fluid" alt="white sample"/>
                        </a> </div>';
                        
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
                    ->addColumn('action', function($row){
                        $id = $row->id;
                        $nama = $row->nama_perlengkapan;
                        $qrcode = route('PerlengkapanQrcode',$id); 
                        $actionBtn = '<a class="btn btn-outline-info m-1" href='.$qrcode.' target="_blank">QRcode</a>';
                        $detail = route('PerlengkapanDetail',$id); 
                        $actionBtn =$actionBtn. '<a class="btn btn-outline-primary m-1" href='.$detail.'>detail</a>';
                        $status = $row->status;
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
                        
                        
                        return $actionBtn;
                    })->rawColumns(['image','kondisi','action'])
                    ->make(true);
            }
    }

    
    public function PerlengkapanPublish($id)
    {
        
        //$mata_pelatihan_id = Crypt::decrypt($id);
        $val = Perlengkapan::where('id', $id)->value('status');
        switch ($val) {
            case '1':
                Perlengkapan::where('id', $id)->update([
                    'status' => 2,
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
                return response()->json(['success'=>'Publish Perlengkapan']);
                break;
                default:
                echo "stikes medistra";
                break;
        }    
    }

    public function PerlengkapanDelete($id)
    {
        
        Perlengkapan::where('id', $id)->update([
            
            'status' => 2,
            'updated_at' => now(),
            ]
        );
        
        return response()->json(['success'=>'Hapus Perlengkapan ']);
        
    }
}
