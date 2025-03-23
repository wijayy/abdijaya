<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stok', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("produk_id");
            $table->string("ukuran")->nullable();
            $table->string("warna")->nullable();
            $table->integer("qty")->nullable();
            $table->integer("harga")->nullable();
            $table->timestamps();

            $table->foreign('produk_id')->references('id')->on('baju')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok');
    }
};
