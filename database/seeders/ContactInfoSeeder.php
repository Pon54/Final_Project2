<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Schema::hasTable('tblcontactusinfo')) {
            // Check if contact info already exists
            $exists = DB::table('tblcontactusinfo')->exists();
            
            if (!$exists) {
                DB::table('tblcontactusinfo')->insert([
                    'Address' => 'Your Company Address Here',
                    'EmailId' => 'info@carrental.com',
                    'ContactNo' => '+1234567890',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
