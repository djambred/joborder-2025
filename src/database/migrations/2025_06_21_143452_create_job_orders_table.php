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
        Schema::create('job_orders', function (Blueprint $table) {
            $table->id();
            $table->string('job_order_number')->unique()->comment('Nomor dari form, e.g., 267/SPK/P4/XII/23');
            $table->date('job_order_date');
            $table->text('work_description');
            $table->enum('work_type', ['new_creation', 'modification', 'installation', 'relocation']);

            // Relasi ke Hirarki Organisasi
            $table->foreignId('department_id')->comment('Departemen tempat JO ini dibuat')->constrained('departments');
            $table->foreignId('requester_id')->comment('Karyawan yang meminta JO')->constrained('employees');
            $table->foreignId('recipient_id')->comment('Karyawan yang ditugaskan (penerima)')->constrained('employees');

            $table->string('status')->default('pending_approval');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_orders');
    }
};
