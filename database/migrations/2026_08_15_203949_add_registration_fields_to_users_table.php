<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('age')->nullable()->after('password');
            $table->string('gender')->nullable()->after('age');
            $table->decimal('height_cm', 5, 2)->nullable()->after('gender');
            $table->decimal('weight_kg', 6, 2)->nullable()->after('height_cm');
            $table->string('role')->default('user')->after('weight_kg');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'age',
                'gender',
                'height_cm',
                'weight_kg',
                'role',
            ]);
        });
    }
};