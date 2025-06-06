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
        Schema::create('produk_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("produk_id");
            $table->unsignedBigInteger("user_id")->nullable();
            $table->text("message")->nullable();

            $table->foreign('produk_id')->references('id')->on('baju')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_history');
    }
};
