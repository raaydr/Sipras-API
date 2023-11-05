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
        'foto_perlengkapan_thumbnail',
        'kondisi_perlengkapan',
        'barcode_perlengkapan',
        'leandable_perlengkapan',
        'status_peminjaman',
        'status',
        'barang_id',
        'mutasi_id',
        'user_id',
        'user_name',
        'editedBy_id',
        'editedBy_name',
        
        
        
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

    public function Barang()
	{
		return $this->belongsTo('App\Models\Barang','barang_id');
	}
    public function Creator()
	{
		return $this->belongsTo('App\Models\User','user_id');
	}

}
