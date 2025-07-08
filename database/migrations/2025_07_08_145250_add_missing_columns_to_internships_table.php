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
        Schema::table('internships', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('skills');
            $table->string('location')->nullable()->after('start_date');
            $table->decimal('remuneration', 10, 2)->nullable()->after('location');
            $table->boolean('remote')->default(false)->after('remuneration');
            $table->boolean('is_active')->default(true)->after('remote');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internships', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'location', 'remuneration', 'remote', 'is_active']);
        });
    }
};
