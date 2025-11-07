<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Schema::hasTable('admin')) {
            $this->command->info("Table 'admin' not found. Skipping admin seeder.");
            return;
        }

        $username = 'admin';
        $passwordPlain = 'admin123';
        $password = md5($passwordPlain); // legacy md5

        $exists = DB::table('admin')->where('UserName', $username)->exists();
        if ($exists) {
            $this->command->info("Admin user '{$username}' already exists. Skipping insert.");
            return;
        }

        // Attempt minimal insert (only fields we know the legacy code uses)
        DB::table('admin')->insert([
            'UserName' => $username,
            'Password' => $password,
        ]);

        $this->command->info("Inserted dev admin user: {$username} / {$passwordPlain} (md5 stored)");
    }
}
