<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Vehicle;
use App\Models\UserLegacy;

class AuthBookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_login_and_booking_flow()
    {
        // create a vehicle
        $vehicle = Vehicle::create([
            'VehiclesBrand' => null,
            'VehiclesTitle' => 'Test Vehicle For Booking',
            'Vimage1' => 'test.jpg',
            'PricePerDay' => 50,
        ]);

        // Register
        $resp = $this->post('/register', [
            'fullname' => 'Test Register',
            'emailid' => 'test_register@example.com',
            'password' => 'password123'
        ]);
        $resp->assertStatus(302);

        $this->assertDatabaseHas('tblusers', ['EmailId' => 'test_register@example.com']);

        // Login
        $resp = $this->post('/login', [
            'email' => 'test_register@example.com',
            'password' => 'password123'
        ]);
        $resp->assertStatus(302);

        // Book vehicle
        $resp = $this->post('/vehicle/' . $vehicle->id . '/book', [
            'FromDate' => now()->toDateString(),
            'ToDate' => now()->addDays(2)->toDateString(),
            'message' => 'Test booking',
            'userEmail' => 'test_register@example.com'
        ]);

        $resp->assertStatus(302);
        $this->assertDatabaseHas('tblbooking', ['userEmail' => 'test_register@example.com']);
    }
}
