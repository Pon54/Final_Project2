<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('tblvehicles', function (Blueprint $table) {
            $table->decimal('rating', 2, 1)->default(0)->after('PricePerDay');
        });
    }

    public function down()
    {
        Schema::table('tblvehicles', function (Blueprint $table) {
            $table->dropColumn('rating');
        });
    }
};
