<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'mutasi';
    protected $fillable = [
        'lokasi_penempatan_lama',
        'lokasi_penempatan_baru',
        'departemen_lama',
        'departemen_baru',
        'tanggal_mutasi',
        'foto_pemindahan',
        'foto_pemindahan_thumbnail',
        'keterangan',
        'status',
        'barang_id',
        'perlengkapan_id',
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

    public function Perlengkapan()
	{
		return $this->belongsTo('App\Models\Perlengkapan','perlengkapan_id');
	}

}
