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
        if (!Schema::hasTable('administrators')) {
            Schema::create('administrators', function (Blueprint $table) {
                // Set the 'id' from the 'persons' table as the primary key
                $table->foreignId('id')->constrained('persons')->primary()->onDelete('cascade'); // 'id' is the primary key, and it references 'persons' table.

                $table->string('level'); // Admin level
                $table->string('remark')->nullable(); // Optional remark

                // Track who created and updated the record
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

                // Timestamps to track created_at and updated_at
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrators');
    }
};
