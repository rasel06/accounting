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
        Schema::disableForeignKeyConstraints();

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_method')->constrained();
            $table->string('invoice_number', 100);
            $table->longText('description');
            $table->foreignId('user_id')->constrained();
            $table->timestamp('invoice_date');
            $table->string('invoice_file', 120);
            $table->decimal('number_of_unit', 8, 2);
            $table->decimal('unit_price', 8, 2);
            $table->decimal('total', 8, 2);
            $table->string('remarks', 200);
            $table->foreignId('payment_method_id');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
