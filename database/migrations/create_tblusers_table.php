<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasTable('tblusers')) {
            Schema::create('tblusers', function (Blueprint $table) {
                $table->id();
                $table->string('FullName');
                $table->string('EmailId')->unique();
                $table->string('ContactNo')->nullable();
                $table->string('Password');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('tblusers');
    }
};
