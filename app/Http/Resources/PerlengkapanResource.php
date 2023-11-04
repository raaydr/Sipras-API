<?php

namespace App\Http\Resources;
use App\Models\Barang;
use App\Models\Perlengkapan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PerlengkapanResource extends JsonResource
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
            'code' => $this->kode_perlengkapan,
            'jumlah' => $this->jumlah_perlengkapan,
            'tanggal'=> Carbon::parse($this->tanggal_pembelian)->isoFormat('D MMMM Y'),
            'barang' => $this->whenLoaded('barang'),
        ];
    }
}
