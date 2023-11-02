<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Perlengkapan;
use App\Http\Resources\PerlengkapanResource;

class PerlengkapanController extends Controller
{
    public function PerlengkapanEdit()
    {
        
        $perlengkapan = Perlengkapan::all();

        
        return PerlengkapanResource::collection($perlengkapan);
    }
}
