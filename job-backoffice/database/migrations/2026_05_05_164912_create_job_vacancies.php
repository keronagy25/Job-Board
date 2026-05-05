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
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->longText('description');
            $table->string('location');
            $table->enum('type', ['full-time', 'part-time', 'contract', 'internship'])->default('full-time');
            $table->decimal('salary', 15, 2)->nullable();
            $table->longText('required_skills')->nullable();
            $table->unsignedInteger('veiw_count')->default(0);
            $table->softDeletes();
            $table->timestamps();

            // Foreign key constraints
            $table->uuid('companyId'); // Foreign key to the companies table
            $table->foreign('companyId')->references('id')->on('companies')->onDelete('restrict');  

            $table->uuid('categoryId'); // Foreign key to the job_categories table
            $table->foreign('categoryId')->references('id')->on('job_categories')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
