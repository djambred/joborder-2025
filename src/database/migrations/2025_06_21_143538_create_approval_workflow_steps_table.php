<?php

use App\Models\ApprovalWorkflow;
use App\Models\Position;
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
        Schema::create('approval_workflow_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ApprovalWorkflow::class);
            $table->integer('step')->comment('Urutan persetujuan, e.g., 1, 2, 3');
            $table->foreignIdFor(Position::class);
            $table->unique(['approval_workflow_id', 'step']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_workflow_steps');
    }
};
