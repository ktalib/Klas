<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('departments')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
