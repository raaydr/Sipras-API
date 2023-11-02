<?php

namespace App\Http\Resources;
use App\Models\Barang;
use App\Models\Perlengkapan;
use Illuminate\Http\Request;
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
        return parent::toArray($request);
    }
}
