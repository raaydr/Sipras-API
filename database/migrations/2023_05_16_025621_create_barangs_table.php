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
        Schema::create('barang', function (Blueprint $table) {
            $table->increments('id');
            $table->text('nama_barang');
            $table->text('kode_barang')->unique();
            $table->text('tipe_barang');
            $table->integer('jumlah')->unsigned();
            $table->text('keterangan');
            $table->boolean('status');
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
        Schema::dropIfExists('barang');
    }
};
