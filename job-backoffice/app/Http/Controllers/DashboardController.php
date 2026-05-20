<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
public function index()
    {   if (auth()->user()->role === 'admin') {
        $analytics = $this->admindashboard();
        }
        else {
            $analytics = $this->companyownerdashboard();
        }
 
        return view('dashboard.index', compact('analytics'));
    }

    private function admindashboard()
    {
        // Active job-seekers in last 30 days
        $userCount = User::where('last_login_at', '>=', now()->subDays(30))
            ->where('role', 'job-seeker')
            ->count();
 
        // Total live jobs
        $totalJobsViewed = JobVacancy::whereNull('deleted_at')->count();
 
        // Total live applications
        $totalApplications = JobApplication::whereNull('deleted_at')->count();
 
        // Top 5 most applied jobs — eager-load company to avoid N+1
        $mostAppliedJobs = JobVacancy::with('company')
            ->withCount('jobApplications')
            ->whereNull('deleted_at')
            ->orderByDesc('job_applications_count')
            ->limit(5)
            ->get();
 
        // Top 3 by conversion rate (applications ÷ views × 100)
        // Only include jobs that have at least 1 view AND 1 application
        $conversionRate = JobVacancy::with('company')
            ->withCount('jobApplications')
            ->whereNull('deleted_at')
            ->where('veiw_count', '>', 0)           // avoid division by zero
            ->having('job_applications_count', '>', 0)
            ->get()
            ->map(function ($job) {
                // Correct formula: applications ÷ views × 100
                $job->conversion_rate = round($job->job_applications_count / $job->veiw_count* 100, 2);
                return $job;
            })
            ->sortByDesc('conversion_rate')         // sort by the computed value
            ->take(3)
            ->values();                             // re-index for @forelse $index
 
        $analytics = [
            'active_users'      => $userCount,
            'total_jobs_viewed' => $totalJobsViewed,
            'total_applications'=> $totalApplications,
            'most_applied_jobs' => $mostAppliedJobs,
            'conversion_rate'   => $conversionRate,
        ];
        return $analytics;
    }

    private function companyownerdashboard()
    {
        //active user who applied for company
        $company = auth()->user()->companies;
        $userCount = User::where('last_login_at', '>=', now()->subDays(30))
            ->where('role', 'job-seeker')
            ->whereHas('jobApplications.jobVacancy', function ($q) use ($company) {
                $q->where('companyId', $company->id);
            })
            ->count();


        //total compamy job
        $totalJobs = $company->jobVacancies->count();

        //total application
        $totalApplication = JobApplication::whereIn('jobId',$company->jobVacancies->pluck('id'))
        ->count();

        //most applied job
        $mostAppliedJobs = JobVacancy::withCount('jobApplications')
        ->whereIn('id',$company->jobVacancies->pluck('id'))
        ->limit(3)
        ->orderByDesc('job_applications_count')
        ->get();

        // Top 3 by conversion rate (applications ÷ views × 100)
        $conversionRate = JobVacancy::with('company')
            ->withCount('jobApplications')
            ->whereIn('id',$company->jobVacancies->pluck('id'))
            ->whereNull('deleted_at')
            ->where('veiw_count', '>', 0)           // avoid division by zero
            ->having('job_applications_count', '>', 0)
            ->get()
            ->map(function ($job) {
                // Correct formula: applications ÷ views × 100
                $job->conversion_rate = round($job->job_applications_count / $job->veiw_count* 100, 2);
                return $job;
            })
            ->sortByDesc('conversion_rate')         // sort by the computed value
            ->take(3)
            ->values();                             // re-index for @forelse $index

        $analytics =[
            'active_users' =>$userCount,
            'total_jobs_viewed' => $totalJobs,
            'total_applications'=> $totalApplication,
            'most_applied_jobs' => $mostAppliedJobs,
            'conversion_rate'   => $conversionRate,
        ];

        return $analytics;
    }

}