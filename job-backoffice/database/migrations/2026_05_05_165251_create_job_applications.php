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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->float('aiGeneratedScore',2)->default(0);
            $table->longText('aiGeneratedFeedback')->nullable();
            $table->softDeletes();
            $table->timestamps();


            // Foreign key constraints
            $table->uuid('jobVacancyId'); // Foreign key to the job_vacancies table
            $table->foreign('jobVacancyId')->references('id')->on('job_vacancies')->onDelete('restrict');

            $table->uuid('resumeId'); // Foreign key to the resumes table
            $table->foreign('resumeId')->references('id')->on('resumes')->onDelete('restrict');

            $table->uuid('applicantId'); // Foreign key to the users table  
            $table->foreign('applicantId')->references('id')->on('users')->onDelete('restrict');    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
