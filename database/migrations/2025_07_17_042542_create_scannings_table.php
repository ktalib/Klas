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
        Schema::create('scannings', function (Blueprint $table) {
            $table->id();
            $table->integer('file_indexing_id');
            $table->string('document_path', 255);
            $table->integer('uploaded_by')->nullable();
            $table->string('status', 50)->default('pending'); // pending | reviewed
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index('file_indexing_id');
            $table->index('uploaded_by');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scannings');
    }
};