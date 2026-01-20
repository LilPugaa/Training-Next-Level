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
        // 1. Tambahkan Registered ke ENUM
        DB::statement("
            ALTER TABLE batch_participants 
            MODIFY status ENUM(
                'Pending',
                'Registered',
                'Approved',
                'Rejected',
                'Ongoing',
                'Completed',
                'Failed'
            ) NOT NULL DEFAULT 'Pending'
        ");

        // 2. Ganti Pending → Registered
        DB::statement("
            UPDATE batch_participants
            SET status = 'Registered'
            WHERE status = 'Pending'
        ");

        // 3. Hapus Pending & set default Registered
        DB::statement("
            ALTER TABLE batch_participants 
            MODIFY status ENUM(
                'Registered',
                'Approved',
                'Rejected',
                'Ongoing',
                'Completed',
                'Failed'
            ) NOT NULL DEFAULT 'Registered'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE batch_participants 
            MODIFY status ENUM(
                'Pending',
                'Approved',
                'Rejected'
            ) NOT NULL DEFAULT 'Pending'
        ");
    }
};
