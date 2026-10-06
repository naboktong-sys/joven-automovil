<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKunjunganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kunjungans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('toko_id')->constrained('tokos')->onDelete('cascade');
            $table->date('tanggal_kunjungan');
            $table->integer('total_qty')->default(0);
            $table->decimal('total_nilai', 15, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->string('foto_kunjungan')->nullable();
            $table->timestamps();

            $table->index('tanggal_kunjungan');
            $table->index('toko_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kunjungan');
    }
}
