<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasTable('tblvehicles')) {
            Schema::create('tblvehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('VehiclesBrand')->nullable();
            $table->string('VehiclesTitle')->nullable();
            $table->string('Vimage1')->nullable();
            $table->string('Vimage2')->nullable();
            $table->string('Vimage3')->nullable();
            $table->string('Vimage4')->nullable();
            $table->string('Vimage5')->nullable();
            $table->string('FuelType')->nullable();
            $table->string('ModelYear')->nullable();
            $table->integer('SeatingCapacity')->nullable();
            $table->text('VehiclesOverview')->nullable();
            $table->decimal('PricePerDay', 10, 2)->default(0);
            // accessories
            $table->boolean('AirConditioner')->default(false);
            $table->boolean('AntiLockBrakingSystem')->default(false);
            $table->boolean('PowerSteering')->default(false);
            $table->boolean('PowerWindows')->default(false);
            $table->boolean('CDPlayer')->default(false);
            $table->boolean('LeatherSeats')->default(false);
            $table->boolean('CentralLocking')->default(false);
            $table->boolean('PowerDoorLocks')->default(false);
            $table->boolean('BrakeAssist')->default(false);
            $table->boolean('DriverAirbag')->default(false);
            $table->boolean('PassengerAirbag')->default(false);
            $table->boolean('CrashSensor')->default(false);

                $table->timestamps();

                $table->foreign('VehiclesBrand')->references('id')->on('tblbrands')->onDelete('set null');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('tblvehicles');
    }
};
