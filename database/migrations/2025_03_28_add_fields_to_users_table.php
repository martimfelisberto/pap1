<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_photo')->nullable()->after('email');
            $table->text('bio')->nullable()->after('profile_photo');
            $table->string('telefone')->nullable()->after('bio');
            $table->json('preferred_categories')->nullable()->after('telefone');
            $table->boolean('is_admin')->default(false)->after('preferred_categories');
            $table->boolean('is_banned')->default(false)->after('is_admin');
            $table->timestamp('last_login_at')->nullable()->after('is_banned');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'profile_photo',
                'bio',
                'telefone',
                'preferred_categories',
                'is_admin',
                'is_banned',
                'last_login_at'
            ]);
        });
    }
};