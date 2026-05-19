<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query=JobApplication::latest();
        if (request()->has('archived')) {
            $query->onlyTrashed();
        }
        $jobApplications = $query->paginate(9)->onEachSide(1);
        return view('job_application.index', compact('jobApplications'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        return view('job_application.show', compact('jobApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        return view('job_application.edit', compact('jobApplication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $validatedData = $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);
        $jobApplication->update([
            'status' => $validatedData['status'],
        ]);
        return redirect()->route('job-applications.index')->with('success', 'Job application updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $jobApplication->delete();
        return redirect()->route('job-applications.index')->with('success', 'Job application archived successfully.');
    }
    public function restore(string $id)
    {
        $jobApplication = JobApplication::withTrashed()->findOrFail($id);
        if ($jobApplication->trashed()) {
            $jobApplication->restore();
            return redirect()->route('job-applications.index')->with('success', 'Job application restored successfully.');
        }
        return redirect()->route('job-applications.index')->with('info', 'Job application is not archived.');
    }
}
