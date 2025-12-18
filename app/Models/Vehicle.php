<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'tblvehicles';
    public $timestamps = false;
    protected $fillable = [
        'VehiclesBrand','VehiclesTitle','Vimage1','Vimage2','Vimage3','Vimage4','Vimage5',
        'FuelType','ModelYear','SeatingCapacity','VehiclesOverview','PricePerDay','rating',
        'AirConditioner','AntiLockBrakingSystem','PowerSteering','PowerWindows',
        'CDPlayer','LeatherSeats','CentralLocking','PowerDoorLocks',
        'BrakeAssist','DriverAirbag','PassengerAirbag','CrashSensor'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'VehiclesBrand');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'VehicleId');
    }
}
