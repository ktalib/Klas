<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add np_fileno column to StFileNo table
        if (Schema::hasTable('StFileNo')) {
            Schema::table('StFileNo', function (Blueprint $table) {
                if (!Schema::hasColumn('StFileNo', 'np_fileno')) {
                    $table->string('np_fileno', 50)->nullable()->after('fileno')->comment('New Primary FileNo (NPFN)');
                }
            });
        }

        // Add np_fileno column to subapplications table
        if (Schema::hasTable('subapplications')) {
            Schema::table('subapplications', function (Blueprint $table) {
                if (!Schema::hasColumn('subapplications', 'np_fileno')) {
                    $table->string('np_fileno', 50)->nullable()->after('fileno')->comment('New Primary FileNo (NPFN)');
                }
            });
        }

        // Add np_fileno column to mother_applications table for reference
        if (Schema::hasTable('mother_applications')) {
            Schema::table('mother_applications', function (Blueprint $table) {
                if (!Schema::hasColumn('mother_applications', 'np_fileno')) {
                    $table->string('np_fileno', 50)->nullable()->after('fileno')->comment('New Primary FileNo (NPFN)');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove np_fileno column from StFileNo table
        if (Schema::hasTable('StFileNo') && Schema::hasColumn('StFileNo', 'np_fileno')) {
            Schema::table('StFileNo', function (Blueprint $table) {
                $table->dropColumn('np_fileno');
            });
        }

        // Remove np_fileno column from subapplications table
        if (Schema::hasTable('subapplications') && Schema::hasColumn('subapplications', 'np_fileno')) {
            Schema::table('subapplications', function (Blueprint $table) {
                $table->dropColumn('np_fileno');
            });
        }

        // Remove np_fileno column from mother_applications table
        if (Schema::hasTable('mother_applications') && Schema::hasColumn('mother_applications', 'np_fileno')) {
            Schema::table('mother_applications', function (Blueprint $table) {
                $table->dropColumn('np_fileno');
            });
        }
    }
};