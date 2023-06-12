<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $fillable = [
        'nama_barang',
        'kode_barang',
        'tipe_barang',
        'jumlah',
        'keterangan',
        'status',
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

    public function perlengkapan()
    {
        return $this->hasMany('App\Models\Perlengkapan');
    }
}
