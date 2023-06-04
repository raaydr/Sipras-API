<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('perlengkapan', function (Blueprint $table) {
            $table->increments('id');
            $table->text('kode_perlengkapan');
            $table->integer('jumlah_perlengkapan')->unsigned();
            $table->integer('harga_perlengkapan')->unsigned();
            $table->text('keterangan_perlengkapan');
            $table->date('tanggal_pembelian')->nullable();
            $table->string('lokasi_perlengkapan')->nullable();
            $table->string('departemen')->nullable();
            $table->text('foto_perlengkapan');
            $table->text('foto_perlengkapan_thumbnail');
            $table->boolean('kondisi_perlengkapan');
            $table->text('barcode_perlengkapan');
            $table->boolean('status');
            $table->boolean('leandable_perlengkapan');
            $table->boolean('status_peminjaman');
            $table->integer('barang_id');
            $table->integer('user_id');
            $table->string('user_name');
            $table->timestamps();

               
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perlengkapan');
    }
};
