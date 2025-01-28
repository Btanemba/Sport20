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
        // Corrected the if statement syntax
        if (!Schema::hasTable('persons')) {
            Schema::create('persons', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->string('first_name');
                $table->string('last_name');
                $table->string('street');
                $table->string('number');
                $table->string('city');
                $table->string('zip');
                $table->string('region');
                $table->string('country');
                $table->string('phone');
                $table->integer('created_by')->nullable();
                $table->integer('updated_by')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persons'); // Fixed table name to match 'persons'
    }
};
