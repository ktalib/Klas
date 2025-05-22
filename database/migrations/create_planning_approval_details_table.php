<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanningApprovalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planning_approval_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id')->nullable();
            $table->unsignedBigInteger('sub_application_id')->nullable();
            $table->text('additional_observations')->nullable();
            $table->timestamps();
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            
            // Add indexes for better performance
            $table->index('application_id');
            $table->index('sub_application_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planning_approval_details');
    }
}
