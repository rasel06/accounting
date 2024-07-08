<?php

use App\Models\User;
use App\Models\Store;
use App\Models\AssetType;
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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();

            //     'description' => 'required',
            // 'storeId' => 'required',
            // 'assetId' => 'required',
            // 'accountId' => 'required',
            // 'txnDate' => 'required|date',
            // 'amount' => 'required|numeric',
            // 'remarks' => 'nullable|string',

            $table->longText('description');
            $table->foreignIdFor(Store::class)->constrained();
            $table->unsignedInteger('account_id');
            $table->foreign('account_id')->references('id')->on('payment_methods');
            $table->foreignIdFor(AssetType::class)->constrained();
            $table->date('txn_date')->nullable();
            $table->decimal('amount', 8, 2);
            $table->longText('remarks', 200);
            $table->foreignIdFor(User::class)->constrained();

            $table->timestamps();

            // $table->unique(['mytext', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
