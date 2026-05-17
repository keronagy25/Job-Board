<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::firstOrCreate([
            'email' => 'admin@admin.com',
        ], [
            'name' => 'Admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $jobData = json_decode(file_get_contents(database_path('data/job_data.json')), true);
        
        //create job categories
        foreach ($jobData['jobCategories'] as $category) {
            JobCategory::firstOrCreate([
                'name' => $category,
            ]);
        }

        //create companies
        foreach($jobData['companies'] as $company) {
            // Create a user for the company owner
            $companyOwner = User::firstOrCreate([
                'email' => fake()->unique()->safeEmail(), // Generate a unique email for the company owner
            ], [
                'name' => $company['name'],
                'password' => Hash::make('password123'), // Default password for company owners
                'role' => 'company-owner',
                'email_verified_at' => now(),
            ]);

            Company::firstOrCreate([
                'name' => $company['name'],
            ], [
                'address' => $company['address'],
                'industry' => $company['industry'],
                'website' => $company['website'],
                'ownerId' => $companyOwner->id, // Associate the company with the created user
            ]);
        }

        //create job vacancies
        foreach($jobData['jobVacancies'] as $jobVacancy) {
            $company = Company::where('name', $jobVacancy['company'])->firstOrFail();
            $category = JobCategory::where('name', $jobVacancy['category'])->firstOrFail();


            JobVacancy::firstOrCreate([
                'title' => $jobVacancy['title'],
                'companyId' => $company->id, // Associate with company
            ], [
                'description' => $jobVacancy['description'],
                'location' => $jobVacancy['location'],
                'type' => $jobVacancy['type'],
                'salary' => $jobVacancy['salary'],
                'categoryId' => $category->id, // Associate with category    
  
            ]);
        }

        $jobApplicationData = json_decode(file_get_contents(database_path('data/job_applications.json')), true);
        //create job applications
        foreach($jobApplicationData['jobApplications'] as $jobApplication) {
            $Applicant_user = User::firstOrCreate([
                'email' => fake()->unique()->safeEmail(), // Generate a unique email for the job seeker
            ], [
                'name' => fake()->name(),
                'password' => Hash::make('password123'), // Default password for job seekers
                'role' => 'job-seeker',
                'email_verified_at' => now(),
            ]);

            $jobVacancy = JobVacancy::inRandomOrder()->first(); // Get a random job vacancy to associate with the application   

            $resume=Resume::firstOrCreate([
                'userId' => $Applicant_user->id, // Associate the resume with the created user
            ], [
                'filename'=> $jobApplication['resume']['filename'],
                'fileUri' => $jobApplication['resume']['fileUri'],
                'contactDetails' => $jobApplication['resume']['contactDetails'],
                'skills' => $jobApplication['resume']['skills'],
                'experience' => $jobApplication['resume']['experience'],
                'education' => $jobApplication['resume']['education'],
                'summary' => $jobApplication['resume']['summary'],
            ]);

            

            JobApplication::firstOrCreate([
                'userId' => $Applicant_user->id, // Associate the application with the created user
                'jobId' => $jobVacancy->id, // Associate the application with a random job vacancy
            ], [
                'aiGeneratedScore' => $jobApplication['aiGeneratedScore'],
                'aiGeneratedFeedback' => $jobApplication['aiGeneratedFeedback'],
                'status' => $jobApplication['status'],
                'resumeId' => $resume->id, // Associate the application with the created resume
            ]);
        }
            

    }
}
