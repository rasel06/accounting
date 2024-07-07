<?php

use App\Models\Location;
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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->unique();
            $table->enum('status', ["active", "inactive"])->default('active');
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Location::class)->constrained();
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
