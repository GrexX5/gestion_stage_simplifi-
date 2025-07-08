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
        Schema::table('conventions', function (Blueprint $table) {
            if (!Schema::hasColumn('conventions', 'teacher_id')) {
                $table->foreignId('teacher_id')->nullable()->after('application_id')->constrained('teachers')->onDelete('set null');
            }
            if (!Schema::hasColumn('conventions', 'student_id')) {
                $table->foreignId('student_id')->after('teacher_id')->constrained('students')->onDelete('cascade');
            }
            if (!Schema::hasColumn('conventions', 'company_id')) {
                $table->foreignId('company_id')->after('student_id')->constrained('companies')->onDelete('cascade');
            }
            if (!Schema::hasColumn('conventions', 'internship_id')) {
                $table->foreignId('internship_id')->after('company_id')->constrained('internships')->onDelete('cascade');
            }
            if (!Schema::hasColumn('conventions', 'start_date')) {
                $table->dateTime('start_date')->after('internship_id');
            }
            if (!Schema::hasColumn('conventions', 'end_date')) {
                $table->dateTime('end_date')->after('start_date');
            }
            if (!Schema::hasColumn('conventions', 'signature_date')) {
                $table->dateTime('signature_date')->nullable()->after('status');
            }
            if (!Schema::hasColumn('conventions', 'notes')) {
                $table->text('notes')->nullable()->after('signature_date');
            }
            // teacher_validated et company_validated sont déjà ajoutés par une migration précédente
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conventions', function (Blueprint $table) {
            if (Schema::hasColumn('conventions', 'teacher_id')) {
                $table->dropForeign(['teacher_id']);
                $table->dropColumn('teacher_id');
            }
            if (Schema::hasColumn('conventions', 'student_id')) {
                $table->dropForeign(['student_id']);
                $table->dropColumn('student_id');
            }
            if (Schema::hasColumn('conventions', 'company_id')) {
                $table->dropForeign(['company_id']);
                $table->dropColumn('company_id');
            }
            if (Schema::hasColumn('conventions', 'internship_id')) {
                $table->dropForeign(['internship_id']);
                $table->dropColumn('internship_id');
            }
            
            $columnsToDrop = [];
            if (Schema::hasColumn('conventions', 'start_date')) {
                $columnsToDrop[] = 'start_date';
            }
            if (Schema::hasColumn('conventions', 'end_date')) {
                $columnsToDrop[] = 'end_date';
            }
            if (Schema::hasColumn('conventions', 'signature_date')) {
                $columnsToDrop[] = 'signature_date';
            }
            if (Schema::hasColumn('conventions', 'notes')) {
                $columnsToDrop[] = 'notes';
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
            
            // Ne pas supprimer teacher_validated et company_validated car ils sont gérés par une autre migration
        });
    }
};
