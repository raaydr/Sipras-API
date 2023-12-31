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
        Schema::create('mutasi', function (Blueprint $table) {
            $table->increments('id');
            $table->text('keterangan');
            $table->date('tanggal_mutasi');
            $table->text('lokasi_penempatan_lama');
            $table->text('lokasi_penempatan_baru');
            $table->string('departemen_lama');
            $table->string('departemen_baru');
            $table->text('foto_pemindahan')->nullable();
            $table->text('foto_pemindahan_thumbnail')->nullable();
            $table->integer('barang_id');
            $table->integer('perlengkapan_id');
            $table->string('user_name');
            $table->integer('user_id');
            $table->string('editedBy_name')->nullable();;
            $table->integer('editedBy_id')->nullable();;
            $table->boolean('status');
            $table->timestamps();
            $table->string('slug'); // Field name same as your `saveSlugsTo`
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mutasi');
    }
};
