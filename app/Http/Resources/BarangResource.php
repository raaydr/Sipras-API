<?php

namespace App\Http\Resources;

use App\Models\Barang;
use App\Models\Perlengkapan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BarangResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'nama_barang' => $this->nama_barang,
            'tipe_barang' => $this->tipe_barang,
            'satuan_barang' => $this->satuan_barang,
            'jumlah' => $this->jumlah,
            'rusak' => $this->rusak,
            'keterangan' => $this->keterangan,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'user_name' => $this->user_name,
            'editedBy_name' => $this->editedBy_name,
            'editedBy_id' => $this->editedBy_id,
            'updated_at'=> Carbon::parse($this->tanggal_pembelian)->isoFormat('D MMMM Y'),
            'created_at'=> Carbon::parse($this->tanggal_pembelian)->isoFormat('D MMMM Y'),
            'deleted_at'=> Carbon::parse($this->tanggal_pembelian)->isoFormat('D MMMM Y'),
            'perlengkapan' => $this->whenLoaded('perlengkapan',function(){
                return collect($this->perlengkapan)->each(function($perlengkap){
                    $perlengkap->creator;
                    return $perlengkap;
                });

            })
        ];
    }
}
