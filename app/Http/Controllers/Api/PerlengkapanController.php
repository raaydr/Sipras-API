<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Perlengkapan;
use Auth;
use Redirect;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use App\Http\Resources\PerlengkapanResource;

class PerlengkapanController extends BaseController
{
    public function PerlengkapanEdit()
    {
        
        $perlengkapan = Perlengkapan::all();

        if (is_null($perlengkapan)) {

            return $this->sendError('Perlengkapan Tidak Ditemukan');

        }

        //return PerlengkapanResource::collection($perlengkapan);

        return $this->sendResponse(PerlengkapanResource::collection($perlengkapan), 'Perlengkapan Berhasil Ditemukan');
        
    }

    public function PerlengkapanDetail($id)
    {
        
        //$perlengkapan = Perlengkapan::with('barang:id,nama_barang,tipe_barang,keterangan')->findOrFail($id);
        $perlengkapan = Perlengkapan::where('id',$id)->first();
        //harus pake id biar bisa kepanggil barangnya

        if (is_null($perlengkapan)) {

            //dd ($perlengkapan);
            return $this->sendError('Perlengkapan Tidak Ditemukan.');

        }
        return $this->sendResponse(new PerlengkapanResource($perlengkapan), 'Perlengkapan Berhasil Ditemukan');
        //return new PerlengkapanResource($perlengkapan);
    }

    public function PerlengkapanData(){
        //$data = Perlengkapan::where('status', '!=',0)->orderBy('id', 'desc')->get();

        $data = DB::table('perlengkapan')->where('perlengkapan.status',1)
        ->join('barang', 'barang.id', '=', 'perlengkapan.barang_id')->where('barang.status',1)
        ->select('barang.nama_barang','barang.satuan_barang','barang.tipe_barang', 'perlengkapan.foto_perlengkapan', 'perlengkapan.foto_perlengkapan_thumbnail', 
        'perlengkapan.kondisi_perlengkapan', 'perlengkapan.status', 'perlengkapan.user_id', 'perlengkapan.kode_perlengkapan', 'perlengkapan.jumlah_perlengkapan', 'perlengkapan.updated_at', 
        'perlengkapan.lokasi_perlengkapan','perlengkapan.departemen','perlengkapan.user_name','perlengkapan.tanggal_pembelian','perlengkapan.keterangan_perlengkapan','perlengkapan.editedBy_name','perlengkapan.id','perlengkapan.barang_id')
        ->orderBy('perlengkapan.updated_at', 'desc')->get();

        foreach ($data as $row) {
            switch ($row->kondisi_perlengkapan) {
                case '1':
                    $row->kondisi_perlengkapan = "bagus";
                    break;
                case '2':
                    $row->kondisi_perlengkapan = "kurang bagus";
                    break;
                case '3':
                    $row->kondisi_perlengkapan = "rusak";
                    break;
                default:
                    $row->kondisi_perlengkapan = "default";
                    break;
            }
            $terakhir = $row->tanggal_pembelian;
            $row->tanggal_pembelian=Carbon::parse($terakhir)->isoFormat('D MMMM Y');
        }
        return $this->sendResponse($data, 'Barang Berhasil Ditemukan');
        //return $this->sendResponse(PerlengkapanResource::collection($data), 'Barang Berhasil Ditemukan');

    }

    public function CreatePerlengkapan(Request $request){
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
            //'foto_perlengkapan' => 'image|mimes:jpeg,png,jpg|max:5120',
            

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

        if ($validator->fails()) {
            $errors = $validator->errors();
            
            $errorMessages = [];

            foreach ($errors->messages() as $field => $messages) {
                foreach ($messages as $message) {
                    $errorMessages[$field] = $message;
                }
            }

            return $this->sendError('Periksa input', $errorMessages);
        }
        

        $id = $request->id;
        $barang_id = $request->barang_id;
        $kode = $request->kode;
       
        $harga_str = preg_replace("/[^0-9]/", "", $request->harga_perlengkapan);
        $harga_perlengkapan = (int) $harga_str;

        
      

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
            
        
        }
            $user_id = Auth::user()->id;        
            $user_name = Auth::user()->name;  
            
            
            $perlengkapan = new Perlengkapan;
            $perlengkapan->jumlah_perlengkapan=$request->jumlah_perlengkapan;
            $perlengkapan->harga_perlengkapan=$harga_perlengkapan;
            $perlengkapan->keterangan_perlengkapan=$request->keterangan_perlengkapan;

            $carbonDate = Carbon::parse($request->tanggal_pembelian);

            // Format the date as needed (in this case, "Y-m-d")
            $formattedDate = $carbonDate->format('Y-m-d');
            $perlengkapan->tanggal_pembelian= $formattedDate;

            $perlengkapan->lokasi_perlengkapan=$request->lokasi_perlengkapan;
            $perlengkapan->departemen=$request->departemen;
            $perlengkapan->kondisi_perlengkapan=$request->kondisi_perlengkapan;
            $perlengkapan->leandable_perlengkapan=$request->leandable_perlengkapan;
            if($request->foto_perlengkapan != NULL){
                $perlengkapan->foto_perlengkapan=$namaFileRILL;
                $perlengkapan->foto_perlengkapan_thumbnail=$namaFileFake;
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
                $jumlah_rusak = Perlengkapan::where('barang_id', $barang_id)->where('status', 1)->where('kondisi_perlengkapan',3)->sum('jumlah_perlengkapan');
                Barang::where('id', $barang_id)->update([
                    'jumlah' => $jumlah_barang,
                    'rusak' => $jumlah_rusak,
                    'updated_at' => now(),
                    ]
                );
            
            
        
            return $this->sendResponse(new PerlengkapanResource($perlengkapan),'Berhasil Create Perlengkapan');
    
    }

    public function UpdatePerlengkapan(Request $request){
        $id = $request->id;
        try {
            DB::beginTransaction();
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
        
        $update['updated_at'] = now(); 
            $user_id = Auth::user()->id;        
            $user_name = Auth::user()->name;
            $level = Auth::user()->level;
            $update['editedBy_id'] = $user_id;      
            $update['editedBy_name'] = $user_name;
            $data = Barang::where('id', $id)->value('user_id');    
            $file = Perlengkapan::where('id', $id)->value('foto_perlengkapan');
            $thumbnail = Perlengkapan::where('id', $id)->value('foto_perlengkapan_thumbnail');
            Perlengkapan::updateOrInsert(
                ['id' => $id], $update
            );
            if($request->foto_perlengkapan != NULL){

            
                
                File::delete('foto-perlengkapan/' . $file);
                File::delete('foto-perlengkapan/' . $thumbnail);
                
                
            }
            $jumlah_barang = Perlengkapan::where('barang_id', $barang_id)->where('status', 1)->where('kondisi_perlengkapan','!=',3)->sum('jumlah_perlengkapan');
            $jumlah_rusak = Perlengkapan::where('barang_id', $barang_id)->where('status', 1)->where('kondisi_perlengkapan',3)->sum('jumlah_perlengkapan');
            Barang::where('id', $barang_id)->update([
                'jumlah' => $jumlah_barang,
                'rusak' => $jumlah_rusak,
                'updated_at' => now(),
                ]
            );

            
    
            DB::commit();
        return $this->sendResponse($barang,'Berhasil Update Perlengkapan');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return $this->sendError(new PerlengkapanResource($update),'periksa input');
        }
    }

    public function DeletePerlengkapan($id){

        $Perlengkapan = Perlengkapan::findOrFail($id);
        $Perlengkapan->delete();
        return $this->sendResponse(new PerlengkapanResource($Perlengkapan), 'Perlengkapan Berhasil Dihapus');
    }

}
