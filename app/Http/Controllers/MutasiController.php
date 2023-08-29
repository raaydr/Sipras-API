<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Perlengkapan;
use App\Models\Mutasi;
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


class MutasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function MutasiEdit()
    {
        $title = 'Welcome Admin';
        
        
        return view('master.dataMutasi');
    }

    public function MutasiDetail($id)
    {
        $title = 'Welcome Admin';
        $Mutasi = Mutasi::where('id',$id)->first();
        $barang = Barang::where('id',$Mutasi->barang_id)->first();
        $harga_Mutasi= $Mutasi->harga_Mutasi;
        return view('master.detailMutasi',compact('barang','Mutasi','harga_Mutasi'));
    }

    public function MutasiUpdate(Request $request){
        $validator = Validator::make($request->all(), 
        [   
            
            'lokasi_penempatan_baru' => 'required|string',
            'departemen_baru' => 'required',
            'keterangan' => 'required',
            'tanggal_mutasi' => 'required|date',
            'foto_pemindahan' => 'nullable',
            'foto_pemindahan' => 'image|mimes:jpeg,png,jpg|max:5120',
            

        ],

        $messages = 
        [
            
            'lokasi_penempatan_baru.required' => 'lokasi penempatan tidak boleh kosong!',
            
            'departemen_baru.required' => 'departemen tidak boleh kosong',            
            'tanggal_mutasi.required' => 'tanggal Mutasi tidak boleh kosong!',

            'keterangan.required' => 'keterangan tidak boleh kosong!',
            
            
            'foto_pemindahan.mimes' => 'foto harus format jpeg,jpg,png!',
            'foto_pemindahan.max' => 'file harus dibawah 5 mb !',
        ]);     

        if($validator->fails())
        {
            return response()->json(['status'=>0, 'msg'=>'periksa input','error'=>$validator->errors()->all()]);
        }
        $update = array();

        $id = $request->id;
        $kode = $request->kode;
        $barang_id = $request->barang_id;
        $perlengkapan_id = $request->perlengkapan_id;
        
        if($request->lokasi_penempatan_lama != NULL){
            $update['lokasi_penempatan_lama'] = $request->lokasi_penempatan_lama;
        }
        if($request->lokasi_penempatan_baru != NULL){
            $update['lokasi_penempatan_baru'] = $request->lokasi_penempatan_baru;
        }
        if($request->keterangan != NULL){
            $update['keterangan'] = $request->keterangan;
        }
        
        if($request->departemen_lama != NULL){
            $update['departemen_lama'] = $request->departemen_lama;
        }
        if($request->departemen_baru != NULL){
            $update['departemen_baru'] = $request->departemen_baru;
        }
        if($request->tanggal_mutasi != NULL){
            $update['tanggal_mutasi'] = $request->tanggal_mutasi;
        }

        if($request->foto_pemindahan != NULL){
            $delete_gambar = Mutasi::where('id', $id)->value('foto_pemindahan');
            $delete_thumbnail = Mutasi::where('id', $id)->value('foto_pemindahan_thumbnail');    
            $image = $request->file('foto_pemindahan');
            $imageThumbnail = Image::make($image);
            $imageName = $image->getClientOriginalName();
            $namaFile = $kode.'_'.time();
            $namaFileRILL = $namaFile.'.'.$image->getClientOriginalExtension();
            $namaFileRILL = preg_replace("/\s+/", "", $namaFileRILL);
            $destinationPath = public_path().'/foto-mutasi/' ;
            $image->move($destinationPath,$namaFileRILL);


                
          
            $namaFileFake = $namaFile.'_thumbnail'.'.'.$image->getClientOriginalExtension();
            $namaFileFake = preg_replace("/\s+/", "", $namaFileFake);
            $destinationPathFake = public_path().'/foto-mutasi/' ;
            $imageThumbnail->save($destinationPath . $namaFileRILL, 20);
            
            $imageThumbnail->resize(200,200, function($constraint)
            {
                $constraint->aspectRatio();
            });
            $imageThumbnail->save($destinationPathFake . $namaFileFake, 20);
            $update['foto_pemindahan'] = $namaFileRILL;
            $update['foto_pemindahan_thumbnail'] = $namaFileFake;
        
        }
        if($request->id != NULL){
            $update['updated_at'] = now(); 
            $user_id = Auth::user()->id;        
            $user_name = Auth::user()->name;
            $update['editedBy_id'] = $user_id;      
            $update['editedBy_name'] = $user_name;    
            $file = Mutasi::where('id', $id)->value('foto_Mutasi');
            $thumbnail = Mutasi::where('id', $id)->value('foto_Mutasi_thumbnail');
    
            Mutasi::updateOrInsert(
                ['id' => $id], $update
            );
            if($request->foto_Mutasi != NULL){

                
                    
                File::delete('foto-mutasi/' . $file);
                File::delete('foto-mutasi/' . $thumbnail);
                
                
            }
        } else{
            $data_id = Perlengkapan::where('id', $perlengkapan_id)->value('user_id');
            $user_id = Auth::user()->id;        
            $user_name = Auth::user()->name;
            $level = Auth::user()->level;  
            if ($level == 0){
                $update['barang_id'] = $barang_id;
                $update['perlengkapan_id'] = $perlengkapan_id;
                
                $update['status'] = 1;
                
                $update['user_id'] = $user_id;      
                $update['user_name'] = $user_name;
                $update['updated_at'] = now(); 
                $update['created_at'] = now(); 
                //Mutasi::updateOrInsert($update);
    
                $datamutasi = new Mutasi;
                $datamutasi->lokasi_penempatan_lama=$update['lokasi_penempatan_lama'];
                $datamutasi->lokasi_penempatan_baru=$update['lokasi_penempatan_baru'];
                $datamutasi->keterangan=$update['keterangan'];
                $datamutasi->departemen_lama=$update['departemen_lama'];
                $datamutasi->departemen_baru=$update['departemen_baru'];
                $datamutasi->tanggal_mutasi=$update['tanggal_mutasi'];
                if($request->foto_pemindahan != NULL){
                    $datamutasi->foto_pemindahan=$update['foto_pemindahan'];
                    $datamutasi->foto_pemindahan_thumbnail=$update['foto_pemindahan_thumbnail'];
                }
                
                $datamutasi->barang_id=$update['barang_id'];
                $datamutasi->perlengkapan_id=$update['perlengkapan_id'];
                $datamutasi->status=$update['status'];
                $datamutasi->user_id=$update['user_id'];
                $datamutasi->user_name=$update['user_name'];
                $datamutasi->perlengkapan_id=$update['perlengkapan_id'];
                $datamutasi->save();
    
    
                $mutasi = array();
                $mutasi['departemen'] =  $update['departemen_baru'] ;
                $mutasi['lokasi_perlengkapan'] =  $update['lokasi_penempatan_baru'];
                $mutasi['mutasi_id'] =  $datamutasi->id;
                Perlengkapan::updateOrInsert(
                    ['id' => $perlengkapan_id], $mutasi
                );

                return response()->json(['status'=>1,'success'=>'Berhasil Update Perlengkapan']);
            }else{
                if($data_id == $user_id){
                    $update['barang_id'] = $barang_id;
                    $update['perlengkapan_id'] = $perlengkapan_id;
                    
                    $update['status'] = 1;
                    
                    $update['user_id'] = $user_id;      
                    $update['user_name'] = $user_name;
                    $update['updated_at'] = now(); 
                    $update['created_at'] = now(); 
                    //Mutasi::updateOrInsert($update);
        
                    $datamutasi = new Mutasi;
                    $datamutasi->lokasi_penempatan_lama=$update['lokasi_penempatan_lama'];
                    $datamutasi->lokasi_penempatan_baru=$update['lokasi_penempatan_baru'];
                    $datamutasi->keterangan=$update['keterangan'];
                    $datamutasi->departemen_lama=$update['departemen_lama'];
                    $datamutasi->departemen_baru=$update['departemen_baru'];
                    $datamutasi->tanggal_mutasi=$update['tanggal_mutasi'];
                    $datamutasi->foto_pemindahan=$update['foto_pemindahan'];
                    $datamutasi->foto_pemindahan_thumbnail=$update['foto_pemindahan_thumbnail'];
                    $datamutasi->barang_id=$update['barang_id'];
                    $datamutasi->perlengkapan_id=$update['perlengkapan_id'];
                    $datamutasi->status=$update['status'];
                    $datamutasi->user_id=$update['user_id'];
                    $datamutasi->user_name=$update['user_name'];
                    $datamutasi->perlengkapan_id=$update['perlengkapan_id'];
                    $datamutasi->save();
        
        
                    $mutasi = array();
                    $mutasi['departemen'] =  $update['departemen_baru'] ;
                    $mutasi['lokasi_perlengkapan'] =  $update['lokasi_penempatan_baru'];
                    $mutasi['mutasi_id'] =  $datamutasi->id;
                    Perlengkapan::updateOrInsert(
                        ['id' => $perlengkapan_id], $mutasi
                    );
    
                    return response()->json(['status'=>1,'success'=>'Berhasil Update Perlengkapan']);
                }else{
                    return response()->json(['status'=>2,'error'=>'Anda tidak bisa melakukan mutasi ini, hanya admin atau pembuat perlengkapan ini']);
                }
            }
            

            
        }
        
        
    }


    public function tabelMutasi(Request $request)
    {
        

        $data = DB::table('perlengkapan')->where('perlengkapan.status',1)
        ->join('barang', 'barang.id', '=', 'perlengkapan.barang_id')
        ->leftjoin('mutasi', 'mutasi.id', '=', 'perlengkapan.mutasi_id')
        ->select('barang.nama_barang', 'perlengkapan.kode_perlengkapan', 'perlengkapan.user_id', 
        'perlengkapan.lokasi_perlengkapan', 'perlengkapan.departemen',
        'perlengkapan.id','perlengkapan.barang_id', 
        'mutasi.lokasi_penempatan_lama','mutasi.lokasi_penempatan_baru',
        'mutasi.departemen_lama','mutasi.departemen_baru','mutasi.foto_pemindahan'
        ,'mutasi.foto_pemindahan_thumbnail','mutasi.keterangan','mutasi.user_name','mutasi.editedBy_name')
        ->orderBy('perlengkapan.updated_at', 'ASC')->get();

        //$data = Perlengkapan::where('status', 1)->orderBy('created_at', 'desc')->get();
            if($request->ajax()){
    
                return datatables()->of($data)                   
                    ->addIndexColumn()
                    ->addColumn('nama_barang', function($row){
                            return $row->nama_barang;
                    }) 
                    ->addColumn('kode_perlengkapan', function($row){
                        return $row->kode_perlengkapan;
                    }) 
                    ->addColumn('image', function($row){
                        if($row->id != NULL){
                            $b = $row->foto_pemindahan;
                            $c = $row->foto_pemindahan_thumbnail;
                            $d = $row->keterangan;
                           
                            if( $b != NULL){
                                $asset= "/foto-mutasi/";
                                $detail=  $asset.$b;
                                $assetThumbnail= "/foto-mutasi/";
                                $thumbnail=  $assetThumbnail.$c;
                                $id = $row->id;
                                $image = '<div class="col-md-8"> <a href='.$detail.' data-toggle="lightbox" >
                                <img src='.$thumbnail.' class="img-fluid" alt="white sample"/>
                                </a> </div>
                                <strong>'.$d.'</strong>';
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
                        }else{
                            return "belum dipindahkan";
                        }
                    }) 
                    ->addColumn('penempatan', function($row){
                        if($row->lokasi_penempatan_lama == NULL){
                            return $row->lokasi_perlengkapan;
                        }else{
                            $awal = $row->lokasi_penempatan_lama;
                            $baru = $row->lokasi_penempatan_baru;
    
                            $penempatan = $awal.' dipindahkan ke '.$baru;
                            return $penempatan;
                        }
                        
                        
                    })
                    ->addColumn('departemen', function($row){
                        if($row->departemen_lama == NULL){
                            
                            return $row->departemen;
                        }else{
                            $awal = $row->departemen_lama;
                            $baru = $row->departemen_baru;

                            $penempatan = $awal.' dipindahkan ke unit '.$baru;
                            return $penempatan;
                        }
                        
                        
                    })  
                    ->addColumn('action', function($row){
                        
                        $perlengkapan_id = $row->id;
                        $barang_id = $row->barang_id;
                        $lokasi_penempatan_lama = $row->lokasi_perlengkapan;
                        $departemen_lama = $row->departemen;
                        $detail = route('PerlengkapanDetail',$perlengkapan_id); 
                        $actionBtn ='<a class="btn btn-outline-primary m-1" href='.$detail.'>detail</a>';
                        
                        
                        
                        return $actionBtn;
                    })->rawColumns(['nama_barang','kode_perlengkapan','image','penempatan','departemen','action'])
                    ->make(true);
            }
    }

    public function tabelMutasiPerlengkapan(Request $request, $id)
    {
        
        $data = Mutasi::where('perlengkapan_id', $id)->where('status', 1)->orderBy('created_at', 'desc')->get();
            if($request->ajax()){
    
                return datatables()->of($data)                   
                    ->addIndexColumn()
                    ->addColumn('Lokasi', function($row){
                        $awal = $row->lokasi_penempatan_lama;
                        $akhir = $row->lokasi_penempatan_baru;
                        $lokasi= 'Dari'.' '.$awal.' '.'pindah ke'.' '.$akhir;
                        return $lokasi;
                    })
                    ->addColumn('Departemen', function($row){
                        $awal = $row->departemen_lama;
                        $akhir = $row->departemen_baru;
                        $departemen= 'Dari'.' '.$awal.' '.'pindah ke'.' '.$akhir;
                        return $departemen;
                    })
                    ->addColumn('tanggal', function($row){
                        $terakhir = $row->tanggal_mutasi;
                        $tanggal_akhir=Carbon::parse($terakhir)->isoFormat('D MMMM Y');
                        return $tanggal_akhir;
                    })
                    ->addColumn('image', function($row){
                        $b = $row->foto_pemindahan;
                        $c = $row->foto_pemindahan_thumbnail;
                        $d = $row->keterangan;
                        if( $b != NULL){
                            $asset= "/foto-mutasi/";
                            $detail=  $asset.$b;
                            $assetThumbnail= "/foto-mutasi/";
                            $thumbnail=  $assetThumbnail.$c;
                            $id = $row->id;
                            $image = '<div class="col-md-8"> <a href='.$detail.' data-toggle="lightbox" >
                            <img src='.$thumbnail.' class="img-fluid" alt="white sample"/>
                            </a> </div>
                            <strong>'.$d.'</strong>';
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
                    ->addColumn('action', function($row){
                        $id = $row->id;
                        
                        $status = $row->status;
                        switch ($status) {
                            case '2':
                                $actionBtn =' <a data-id="'.$id.'" class="btn btn-outline-success m-1 publishMutasi">Kembalikan</a>';
                                break;
                            case '1':
                                $actionBtn =' 
                                <a id="hapus" data-toggle="modal" data-target="#hapus-Mutasi'.$id.'" class="btn btn-outline-danger m-1">Hapus</a></dl>
                                                            <div class="modal fade" id="hapus-Mutasi'.$id.'">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content bg-danger">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Penolakan</h4>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">    
                                                                                <p>Apa anda yakin ingin menghapus Mutasi  ini ?</p>
                                                                                <div class="modal-footer justify-content-between">
                                                                                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                                                                <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$id.'" data-dismiss="modal" data-original-title="Delete" class="btn btn-outline-light deleteMutasi">Delete</a>
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
                    })->rawColumns(['Lokasi','Departemen','tanggal','image','action'])
                    ->make(true);
            }
    }
    public function MutasiPublish($id)
    {
        
        //$mata_pelatihan_id = Crypt::decrypt($id);
        $val = Mutasi::where('id', $id)->value('status');
        switch ($val) {
            case '1':
                Mutasi::where('id', $id)->update([
                    'status' => 2,
                    'updated_at' => now(),
                    ]
                );
                return response()->json(['success'=>'Batal Publish Mutasi']);
                break;
            case '2':
                Mutasi::where('id', $id)->update([
                    'status' => 1,
                    'updated_at' => now(),
                    ]
                );
                return response()->json(['success'=>'Publish Mutasi']);
                break;
                default:
                echo "stikes medistra";
                break;
        }    
    }

    public function MutasiDelete($id)
    {
        $perlengkapan_id = Mutasi::where('id', $id)->value('perlengkapan_id');
        $data_id = Perlengkapan::where('id', $perlengkapan_id)->value('user_id');
        $user_id = Auth::user()->id;        
        $user_name = Auth::user()->name;  

        if($data_id == $user_id){
            Mutasi::where('id', $id)->update([
            
                'status' => 2,
                'updated_at' => now(),
                ]
            );
            $file = Mutasi::where('id', $id)->value('foto_pemindahan');
            $thumbnail = Mutasi::where('id', $id)->value('foto_pemindahan_thumbnail');
            File::delete('foto-mutasi/' . $file);
            File::delete('foto-mutasi/' . $thumbnail);
            return response()->json(['status'=>1,'success'=>'Berhasil Hapus Mutasi']);
        }else{
            return response()->json(['status'=>0,'error'=>'Anda tidak bisa menghapus mutasi ini, hanya admin atau pembuat perlengkapan ini']);
        }
        
        
    }
}
