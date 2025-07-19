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
        Schema::create('pagetypings', function (Blueprint $table) {
            $table->id();
            $table->integer('file_indexing_id');
            $table->string('page_type', 100);
            $table->string('page_subtype', 100)->nullable();
            $table->integer('serial_number');
            $table->string('page_code', 100)->nullable();
            $table->string('file_path', 255);
            $table->integer('typed_by')->nullable();
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index('file_indexing_id');
            $table->index('page_type');
            $table->index('typed_by');
            $table->index('serial_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagetypings');
    }
};