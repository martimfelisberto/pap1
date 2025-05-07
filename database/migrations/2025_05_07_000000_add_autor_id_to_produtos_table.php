<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    public function up(): void
    {
        // Check if the column doesn't already exist
        if (!Schema::hasColumn('produtos', 'autor_id')) {
            Schema::table('produtos', function (Blueprint $table) {
                $table->foreignId('autor_id')
                      ->nullable()
                      ->after('id')
                      ->constrained('users')
                      ->onDelete('set null');
            });
        }

        // Only run update if the column exists and is nullable
        if (Schema::hasColumn('produtos', 'autor_id')) {
            try {
                DB::statement('
                    UPDATE produtos p
                    JOIN users u ON p.user_id = u.id
                    SET p.autor_id = u.id
                    WHERE p.autor_id IS NULL
                ');
            } catch (\Exception $e) {
                Log::error('Failed to update autor_id: ' . $e->getMessage());
            }
        }
    }

    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            if (Schema::hasColumn('produtos', 'autor_id')) {
                $table->dropForeign(['autor_id']);
                $table->dropColumn('autor_id');
            }
        });
    }
};