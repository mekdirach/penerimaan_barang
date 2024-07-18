<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenerimaanBarangsTable extends Migration
{
    public function up()
    {
        Schema::create('penerimaan_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('no_penerimaan')->unique();
            $table->string('no_surat_jalan');
            $table->unsignedBigInteger('supplier_id');
            $table->date('tanggal');
            $table->json('multiple_input');
            $table->decimal('total_berat_real', 8, 2);
            $table->decimal('total_berat_kotor', 8, 2);
            $table->decimal('berat_timbangan', 8, 2);
            $table->decimal('berat_selisih', 8, 2);
            $table->string('catatan')->nullable();
            $table->string('tipe_pembayaran');
            $table->decimal('harga_beli', 10, 2)->nullable();
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->string('nama_pengirim');
            $table->unsignedBigInteger('pic_id');
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('pic_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penerimaan_barangs');
    }
}
