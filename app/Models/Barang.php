<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Barang extends Model
{
    use HasFactory,SoftDeletes,HasSlug;
    protected $table = 'barang';
    protected $fillable = [
        'nama_barang',
        'kode_barang',
        'tipe_barang',
        'jumlah',
        'rusak',
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
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nama_barang')
            ->saveSlugsTo('slug');
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function perlengkapan()
    {
        return $this->hasMany('App\Models\Perlengkapan');
    }

    
}
