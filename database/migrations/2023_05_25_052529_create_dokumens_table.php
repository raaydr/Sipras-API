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
        Schema::create('dokumen', function (Blueprint $table) {
            $table->increments('id');
            $table->text('judul');
            $table->text('nomor')->nullable();
            $table->text('unit')->nullable();
            $table->date('terbit');
            $table->date('kadaluarsa')->nullable();
            $table->string('kategori')->nullable();
            $table->integer('unit_id')->nullable();
            $table->string('nama_pembuat');
            $table->text('link_dokumen');
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
        Schema::dropIfExists('dokumen');
    }
};
