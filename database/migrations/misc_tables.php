<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasTable('tbltestimonial')) {
            Schema::create('tbltestimonial', function (Blueprint $table) {
                $table->id();
                $table->text('Testimonial');
                $table->string('UserEmail')->nullable();
                $table->tinyInteger('status')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('tblcontactusquery')) {
            Schema::create('tblcontactusquery', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('EmailId');
                $table->string('ContactNumber')->nullable();
                $table->text('Message');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('tblsubscribers')) {
            Schema::create('tblsubscribers', function (Blueprint $table) {
                $table->id();
                $table->string('SubscriberEmail')->unique();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('tbltestimonial');
        Schema::dropIfExists('tblcontactusquery');
        Schema::dropIfExists('tblsubscribers');
    }
};
