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
    Schema::create('queue_tickets', function (Blueprint $table) {
        $table->id();

        $table->foreignId('patient_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->foreignId('polyclinic_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->foreignId('doctor_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->string('queue_code');
        $table->date('queue_date');

        $table->enum('status', [
            'waiting',
            'called',
            'done',
            'cancelled',
        ])->default('waiting');

        $table->integer('estimated_waiting_minutes')->default(0);
        $table->text('complaint')->nullable();

        $table->timestamp('called_at')->nullable();
        $table->timestamp('finished_at')->nullable();

        $table->timestamps();

        $table->unique(['queue_date', 'queue_code']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queue_tickets');
    }
};
