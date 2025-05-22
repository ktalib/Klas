<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticularsRegistrationSequenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('particulars_registration_sequence', function (Blueprint $table) {
            $table->id();
            $table->integer('last_serial_no')->default(0);
            $table->integer('last_page_no')->default(0);
            $table->integer('last_volume_no')->default(1);
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
        
        // Initialize with values that will generate "1/1/1" as the first number
        DB::table('particulars_registration_sequence')->insert([
            'last_serial_no' => 0,
            'last_page_no' => 0,
            'last_volume_no' => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('particulars_registration_sequence');
    }
}
