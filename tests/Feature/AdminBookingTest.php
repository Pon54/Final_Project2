<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
class AdminBookingTest extends TestCase
{
    /** @test */
    public function admin_can_change_booking_status()
    {
        // This test assumes legacy migrations exist. We'll insert rows directly.
    if (!Schema::hasTable('tblbooking')) {
            $this->markTestSkipped('Legacy booking table not present');
        }

        // create admin session by setting session value
        $brandId = DB::table('tblbrands')->insertGetId(['BrandName' => 'TestBrand']);
        $vehicleId = DB::table('tblvehicles')->insertGetId([
            'VehiclesTitle' => 'TestCar',
            'VehiclesBrand' => $brandId,
            'PricePerDay' => 100,
        ]);
        $email = 'test@example.com';
        DB::table('tblusers')->insert(['FullName' => 'Tester','EmailId'=>$email,'ContactNo'=>'','Password'=>md5('pass')]);

        $bookingId = DB::table('tblbooking')->insertGetId([
            'BookingNumber' => 'TST'.time(),
            'userEmail' => $email,
            'VehicleId' => $vehicleId,
            'FromDate' => now()->format('Y-m-d'),
            'ToDate' => now()->addDays(2)->format('Y-m-d'),
            'message' => 'test',
            'Status' => 'new'
        ]);

        $response = $this->withSession(['alogin' => 'admin'])->post(route('admin.bookings.setstatus', $bookingId), ['status' => 'confirmed']);
        $response->assertStatus(302);
        $this->assertDatabaseHas('tblbooking', ['id' => $bookingId, 'Status' => 'confirmed']);
    }
}
