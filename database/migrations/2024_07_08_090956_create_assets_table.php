<?php

use App\Models\User;
use App\Models\Store;
use App\Models\PaymentMethod;
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
            $table->longText('description');
            $table->foreignIdFor(Store::class)->constrained()->onUpdate('cascade');

            // $table->unsignedInteger('account_id');
            // $table->foreign('account_id')->references('id')->on('payment_methods')->onUpdate('cascade');
            // credit_account_id

            // $table->foreignIdFor(PaymentMethod::class, 'account_id')->constrained();
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')->references('id')->on('payment_methods')->onUpdate('cascade');

            $table->foreignIdFor(AssetType::class)->constrained()->onUpdate('cascade');

            $table->date('txn_date')->nullable();
            $table->decimal('amount', 8, 2);
            $table->longText('remarks', 200);
            $table->foreignIdFor(User::class)->constrained();
            $table->timestamps();
            // $table->unique(['store_id', 'account_id', 'asset_type_id'], 'store_account_assetType_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('assets', function (Blueprint $table) {
        //     $table->dropUnique('store_account_assetType_id');
        // });
        Schema::dropIfExists('assets');
    }
};
