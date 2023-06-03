<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perlengkapan extends Model
{
    use HasFactory;
    protected $table = 'perlengkapan';
    protected $fillable = [
        'kode_perlengkapan',
        'jumlah_perlengkapan',
        'harga_perlengkapan',
        'keterangan_perlengkapan',
        'tanggal_pembelian',
        'lokasi_perlengkapan',
        'departemen',
        'foto_perlengkapan',
        'kondisi_perlengkapan',
        'barcode_perlengkapan',
        'lendable_perlengkapan',
        'status_peminjaman',
        'status',
        'user_id',
        'user_name',
        
        
        
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
 
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
