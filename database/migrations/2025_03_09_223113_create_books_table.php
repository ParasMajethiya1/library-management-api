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
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id'); // Auto-incrementing primary key
            $table->string('title'); // Book title
            $table->string('author'); // Book author
            $table->text('description')->nullable(); // Optional book description
            $table->string('status')->default('available'); // Book status (e.g., available, borrowed)
            $table->unsignedBigInteger('borrower_id')->nullable(); // Track the borrower
            $table->foreign('borrower_id')->references('id')->on('users')->onDelete('set null'); // Foreign key to users table
            $table->timestamps(); // created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
