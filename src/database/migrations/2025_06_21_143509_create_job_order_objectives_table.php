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
        Schema::create('job_order_objectives', function (Blueprint $table) {
            $table->unique(['job_order_id', 'objective_id']);
            $table->foreignId('job_order_id')->constrained('job_orders')->onDelete('cascade');
            $table->foreignId('objective_id')->constrained('objectives')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_order_objectives');
    }
};
