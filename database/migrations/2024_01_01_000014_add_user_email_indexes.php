<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * This migration adds an index on UserEmail fields for better performance
     * when querying bookings and testimonials by user email.
     */
    public function up()
    {
        Schema::table('tbltestimonial', function (Blueprint $table) {
            // Add index on UserEmail for faster lookups
            if (!Schema::hasColumn('tbltestimonial', 'UserEmail')) {
                return;
            }
            $table->index('UserEmail', 'idx_testimonial_user_email');
        });

        Schema::table('tblbooking', function (Blueprint $table) {
            // Add index on userEmail for faster lookups
            if (!Schema::hasColumn('tblbooking', 'userEmail')) {
                return;
            }
            $table->index('userEmail', 'idx_booking_user_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('tbltestimonial', function (Blueprint $table) {
            $table->dropIndex('idx_testimonial_user_email');
        });

        Schema::table('tblbooking', function (Blueprint $table) {
            $table->dropIndex('idx_booking_user_email');
        });
    }
};
