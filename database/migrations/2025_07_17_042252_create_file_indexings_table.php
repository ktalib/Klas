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
        Schema::create('file_indexings', function (Blueprint $table) {
            $table->id();
            $table->integer('main_application_id');
            $table->string('file_number', 100)->nullable();
            $table->string('file_title', 255)->nullable();
            $table->string('land_use_type', 100)->nullable();
            $table->string('plot_number', 100)->nullable();
            $table->string('district', 100)->nullable();
            $table->string('lga', 100)->nullable();
            $table->boolean('has_cofo')->default(false);
            $table->boolean('is_merged')->default(false);
            $table->boolean('has_transaction')->default(false);
            $table->boolean('is_problematic')->default(false);
            $table->timestamps();
            
            // Add index for better performance
            $table->index('main_application_id');
            $table->index('file_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_indexings');
    }
};