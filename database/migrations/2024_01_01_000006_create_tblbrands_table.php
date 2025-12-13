<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasTable('tblbrands')) {
            Schema::create('tblbrands', function (Blueprint $table) {
                $table->id();
                $table->string('BrandName');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('tblbrands');
    }
};
