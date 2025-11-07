<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'tblbooking';
    public $timestamps = false;
    protected $guarded = [];

    public function vehicle()
    {
        return $this->belongsTo(\App\Models\Vehicle::class, 'VehicleId');
    }

    public function user()
    {
        // bookings.userEmail maps to tblusers.EmailId
        return $this->belongsTo(\App\Models\UserLegacy::class, 'userEmail', 'EmailId');
    }

    // human-readable status accessor
    public function getStatusTextAttribute()
    {
        $map = [0 => 'new', 1 => 'confirmed', 2 => 'canceled'];
        return $map[$this->Status] ?? $this->Status;
    }
}
