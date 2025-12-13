<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Convert tblpages table to utf8mb4 to support emojis
        DB::statement('ALTER TABLE tblpages CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        
        // Also ensure the detail column specifically supports utf8mb4
        DB::statement('ALTER TABLE tblpages MODIFY COLUMN detail LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        DB::statement('ALTER TABLE tblpages MODIFY COLUMN PageName VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        DB::statement('ALTER TABLE tblpages MODIFY COLUMN type VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to latin1 (not recommended, but for rollback)
        DB::statement('ALTER TABLE tblpages CONVERT TO CHARACTER SET latin1 COLLATE latin1_swedish_ci');
    }
};
