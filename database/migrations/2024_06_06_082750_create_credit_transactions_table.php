<?php

use App\Models\User;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('credit_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PaymentMethod::class, 'credit_account_id')->constrained();
            // $table->foreignId('credit_account_id');  // payment_method_id
            //$table->foreignId('payment_method')->constrained();
            $table->longText('description');
            $table->string('invoice_number', 50);
            $table->date('invoice_date')->nullable();
            $table->string('invoice_file', 120)->nullable();
            $table->decimal('amount', 8, 2);
            $table->string('remarks', 200);
            $table->foreignIdFor(User::class)->constrained();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_transactions');
    }
};
