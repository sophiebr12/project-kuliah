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
        Schema::create('hasils', function (Blueprint $table) {
            $table->id();
            $table->foreignId("bobot_id");
            // $table->foreignId("supplier_id");
            $table->foreignId("supplier_item_id");
            $table->double("harga");
            $table->double("lead_time");
            $table->double("grade");
            $table->double("pembayaran");
            $table->double("score");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasils');
    }
};
