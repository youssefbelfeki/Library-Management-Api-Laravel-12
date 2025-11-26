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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'book_id')->constrained(table: 'books')->cascadeOnDelete();
            $table->foreignId(column: 'member_id')->constrained(table: 'members')->cascadeOnDelete();
            $table->date(column: 'borrowed_date');
            $table->date(column: 'due_date');
            $table->date(column: 'returned_date')->nullable();
            $table->enum(column: 'status', allowed: ['borrowed', 'returned', 'overdue'])->default(value: 'borrowed');
            $table->timestamps();
            //index  
            $table->index(columns: ['member_id', 'status']);
            $table->index(columns: 'due_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
