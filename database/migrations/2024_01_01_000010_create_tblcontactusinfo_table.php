<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasTable('tblcontactusinfo')) {
            Schema::create('tblcontactusinfo', function (Blueprint $table) {
                $table->id();
                $table->text('Address')->nullable();
                $table->string('EmailId')->nullable();
                $table->string('ContactNo')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('tblcontactusinfo');
    }
};
