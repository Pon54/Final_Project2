<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasTable('tblbooking')) {
            Schema::create('tblbooking', function (Blueprint $table) {
            $table->id();
            $table->string('BookingNumber')->nullable();
            $table->string('userEmail')->nullable();
            $table->unsignedBigInteger('VehicleId')->nullable();
            $table->date('FromDate')->nullable();
            $table->date('ToDate')->nullable();
            $table->text('message')->nullable();
            $table->tinyInteger('Status')->default(0);
            $table->timestamp('PostingDate')->useCurrent();
            $table->timestamps();

                $table->foreign('VehicleId')->references('id')->on('tblvehicles')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('tblbooking');
    }
};
