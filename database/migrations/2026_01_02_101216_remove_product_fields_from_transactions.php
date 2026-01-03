<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {

            // 1️⃣ Drop foreign key dulu
            $table->dropForeign(['product_id']);

            // 2️⃣ Baru drop kolom
            $table->dropColumn(['product_id', 'quantity']);
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {

            // rollback (opsional)
            $table->foreignId('product_id')->constrained();
            $table->integer('quantity');
        });
    }
};
