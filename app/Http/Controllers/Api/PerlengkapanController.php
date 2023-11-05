<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Perlengkapan;
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
        
        $perlengkapan = Perlengkapan::with('barang:id,nama_barang,tipe_barang,keterangan')->findOrFail($id);
        //harus pake id biar bisa kepanggil barangnya

        if (is_null($perlengkapan)) {

            //dd ($perlengkapan);
            return $this->sendError('Perlengkapan Tidak Ditemukan.');

        }
        return $this->sendResponse(new PerlengkapanResource($perlengkapan), 'Perlengkapan Berhasil Ditemukan');
        //return new PerlengkapanResource($perlengkapan);
    }
}
