<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobVacancyCreateRequest;
use App\Http\Requests\JobVacancyUpdateRequest;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query=JobVacancy::latest();
        if (auth()->user()->role == 'company-owner') {
            $company = auth()->user()->companies;
            $query->where('companyId', $company->id); // company's own ID
        }
        if (request()->has('archived')) {
            $query->onlyTrashed();
        }
        $jobVacancies = $query->paginate(9)->onEachSide(1);
        return view('job_vacancy.index', compact('jobVacancies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = auth()->user()->role == 'admin' ? Company::all() : collect();
        $jobcategories = JobCategory::all();
        return view('job_vacancy.create', compact('companies', 'jobcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobVacancyCreateRequest $request)
    {
        $jobVacancy = JobVacancy::create($request->validated());
        return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        return view('job_vacancy.show', compact('jobVacancy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $companies = Company::all();
        $jobcategories = JobCategory::all();
        return view('job_vacancy.edit', compact('jobVacancy', 'companies', 'jobcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobVacancyUpdateRequest $request, string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->update($request->validated());
        return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->delete();
        return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy deleted successfully.');
    }

    public function restore(string $id)
    {
        $jobVacancy = JobVacancy::onlyTrashed()->findOrFail($id);
        $jobVacancy->restore();
        return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy restored successfully.');
    }
}
