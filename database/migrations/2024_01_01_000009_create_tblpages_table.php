<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasTable('tblpages')) {
            Schema::create('tblpages', function (Blueprint $table) {
                $table->id();
                $table->string('PageName')->nullable();
                $table->string('type')->nullable()->index();
                $table->text('detail')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('tblpages');
    }
};
