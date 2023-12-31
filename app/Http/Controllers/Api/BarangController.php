<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Perlengkapan;
use App\Http\Resources\BarangResource;
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

class BarangController extends BaseController
{
    public function BarangDetail($id)
    {
        $barang = Barang::with('perlengkapan:barang_id,kode_perlengkapan,user_id')->where('id',$id)->first();
        //$barang = Barang::with('perlengkapan:barang_id,kode_perlengkapan,user_id')->findOrFail($id);
        return $this->sendResponse(new BarangResource($barang), 'Barang Berhasil Ditemukan');
    }
    public function CreateBarang(Request $request){
        $validator = Validator::make($request->all(), 
        [   
            
            'nama_barang' => 'required|string',
            'kode_barang' => 'required|string|unique:barang,kode_barang',
            'tipe_barang' => 'required|string',
            'satuan_barang' => 'required|string',
            'keterangan' => 'required',
        ],

        $messages = 
        [
            
            'nama_barang.required' => 'nama barang tidak boleh kosong!',
            'kode_barang.required' => 'kode barang tidak boleh kosong!',
            'kode_barang.unique' => 'kode barang sudah dipakai',            
            'tipe_barang.required' => 'tipe barang unit tidak boleh kosong!',
            'satuan_barang.required' => 'satuan barang tidak boleh kosong!',
            'keterangan.required' => 'keterangan barang tidak boleh kosong!',
            
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
        
            
            $barang = new Barang;
            $barang->nama_barang =  $request->nama_barang;
            $barang->kode_barang =  $request->kode_barang;
            $barang->tipe_barang =  $request->tipe_barang;
            $barang->satuan_barang =  $request->satuan_barang;
            $barang->keterangan =  $request->keterangan;
            $barang->status =  1;
            $barang->jumlah =  0;
            $barang->rusak =  0;
            $user_id = Auth::user()->id;
            $user_name = Auth::user()->name;
            $barang->user_id =  $user_id;
            $barang->user_name =  $user_name;
            $barang->editedBy_id =  $user_id;
            $barang->editedBy_name =  $user_name;
            $barang->save();
            
        
        return $this->sendResponse($barang,'Berhasil Create Barang');
        //return response()->json(['status'=>1,'success'=>'Berhasil Update Dokumen']);
        
        
    }

    public function UpdateBarang(Request $request){
        $id = $request->id;
        try {
            DB::beginTransaction();
            $validator = Validator::make($request->all(), 
        [   
            
            
            'nama_barang' => 'nullable|string',
            'kode_barang' => 'nullable|string|unique:barang,kode_barang,'.$id,
            'tipe_barang' => 'nullable|string',
            'satuan_barang' => 'nullable|string',
            'keterangan' => 'nullable',
        ],

        $messages = 
        [
            
            'kode_barang.unique' => 'kode barang tidak boleh sama',            
            
        ]);     

        if($validator->fails())
        {
            return $this->sendError('periksa input',$validator->errors()->all());
        }
        $update = array();

        
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

        $update['updated_at'] = now(); 
        $user_id = Auth::user()->id;        
        $user_name = Auth::user()->name;
        $update['editedBy_id'] = $user_id;      
        $update['editedBy_name'] = $user_name;    
        Barang::updateOrInsert(
            ['id' => $id], $update
        );
        $barang = Barang::findOrFail($id);

            
    
            DB::commit();
        return $this->sendResponse($barang,'Berhasil Update Barang');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            
        }
    }

    public function DeleteBarang($id){

        $barang = Barang::where('id',$id    )->first();
        Barang::where('id', $id)->update([
            'status' => 2,
            'updated_at' => now(),
            ]
        );
        return $this->sendResponse(new BarangResource($barang), 'Barang Berhasil Dihapus');
    }

    public function BarangData(){
        $data = Barang::where('status',1)->orderBy('id', 'desc')->get();

        return $this->sendResponse(BarangResource::collection($data), 'Barang Berhasil Ditemukan');

    }
}
