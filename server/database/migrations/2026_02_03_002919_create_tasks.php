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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->string('title');
            $table->string('priority');
            $table->string('sector');
            $table->string('responsible');
            $table->string('who_should_test');
            $table->string('description');
            $table->string('midia');
            $table->boolean('customer_charged')->default(false);
            $table->integer('estimated_time')->default(0);
            $table->integer('time_spent')->default(0);
            $table->string('status')->default('Backlog');
            $table->boolean('return')->default(false);
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
