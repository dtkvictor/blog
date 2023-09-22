<?php

use App\Models\Log;
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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user')->nullable();
            $table->enum('action', Log::actions());
            $table->string('model');
            $table->string('message')->nullable();
            $table->timestamps();

            $table->foreign('user')->references('id')->on('users')->onDelete("SET NULL");
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
