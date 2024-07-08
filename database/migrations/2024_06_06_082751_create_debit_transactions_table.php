<?php

use App\Models\PaymentMethod;
use App\Models\Store;
use App\Models\User;
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

        Schema::create('debit_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Store::class, 'store_id')->constrained();
            $table->foreignIdFor(PaymentMethod::class, 'payment_method_id')->constrained();
            $table->longText('description');
            $table->string('invoice_number', 50);
            $table->date('invoice_date')->nullable();
            $table->string('invoice_file', 120)->nullable();
            $table->decimal('number_of_unit', 8, 2);
            $table->decimal('unit_price', 8, 2);
            $table->decimal('total', 8, 2);
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
        Schema::dropIfExists('debit_transactions');
    }
};
