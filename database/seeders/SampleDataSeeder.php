<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        // Ensure tables exist
        if (!Schema::hasTable('tblbrands') || !Schema::hasTable('tblvehicles') || !Schema::hasTable('tblusers') || !Schema::hasTable('tblbooking')) {
            $this->command->info('Legacy tables missing; skipping sample data seeder.');
            return;
        }

        // Brand
        $brandId = DB::table('tblbrands')->insertGetId([
            'BrandName' => 'Acme Motors'
        ]);

        // Vehicle
        $vehicleId = DB::table('tblvehicles')->insertGetId([
            'VehiclesTitle' => 'Acme Sedan',
            'VehiclesBrand' => $brandId,
            'PricePerDay' => 1200,
            'FuelType' => 'Petrol',
            'ModelYear' => '2020',
            'SeatingCapacity' => 5,
            'Vimage1' => null
        ]);

        // User
        $userEmail = 'devuser@example.com';
        $exists = DB::table('tblusers')->where('EmailId', $userEmail)->exists();
        if (!$exists) {
            DB::table('tblusers')->insert([
                'FullName' => 'Dev User',
                'EmailId' => $userEmail,
                'ContactNo' => '09171234567',
                'Password' => md5('password')
            ]);
        }

        // Booking (BookingNumber is numeric in legacy schema)
        DB::table('tblbooking')->insert([
            'BookingNumber' => time(),
            'userEmail' => $userEmail,
            'VehicleId' => $vehicleId,
            'FromDate' => date('Y-m-d', strtotime('+1 day')),
            'ToDate' => date('Y-m-d', strtotime('+3 days')),
            'message' => 'Test booking from seeder',
            'Status' => 0
        ]);

        $this->command->info('Inserted sample brand, vehicle, user, and booking.');
    }
}
