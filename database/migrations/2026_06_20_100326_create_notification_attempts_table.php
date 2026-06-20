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
        Schema::create('notification_attempts', function (Blueprint $table) {

            $table->id();

            $table->foreignId('notification_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('attempt_number');

            $table->enum('status', [
                'Success',
                'Failed',
            ]);

            $table->text('error_message')->nullable();

            $table->timestamp('attempted_at');

            $table->timestamps();

            $table->index('notification_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_attempts');
    }
};
