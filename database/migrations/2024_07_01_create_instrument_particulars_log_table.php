<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstrumentParticularsLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instrument_particulars_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instrument_id');
            $table->integer('serial_no');
            $table->integer('page_no');
            $table->integer('volume_no');
            $table->string('generated_particulars_number');
            $table->timestamps();
            
            $table->foreign('instrument_id')
                  ->references('id')
                  ->on('instrument_registration')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instrument_particulars_log');
    }
}
