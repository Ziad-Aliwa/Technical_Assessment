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
        Schema::create('notifications', function (Blueprint $table) {

            $table->id();

            $table->foreignId('ticket_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('channel');

            $table->enum('status', [
                'Pending',
                'Success',
                'Failed',
            ])->default('Pending');

            $table->timestamp('sent_at')->nullable();

            $table->text('error_message')->nullable();

            $table->timestamps();

            $table->index('ticket_id');
            $table->index('channel');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
