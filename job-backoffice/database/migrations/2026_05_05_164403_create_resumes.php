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
        Schema::create('resumes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('filename');
            $table->string('fileUri');
            $table->string('contactDetails');
            $table->longText('summary')->nullable();
            $table->longText('skills')->nullable();
            $table->longText('experience')->nullable();
            $table->longText('education')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->uuid('userId'); // Foreign key to the users table
            $table->foreign('userId')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
