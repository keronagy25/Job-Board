<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobCategoryCreateRequest;
use App\Models\JobCategory;
use Illuminate\Http\Request;


class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query=JobCategory::latest();
        //archived
        if ($request->has('archived')) {
            $query->onlyTrashed();
        }
        $jobCategories = $query->paginate(9)->onEachSide(1);
        return view('job_category.index', compact('jobCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('job_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobCategoryCreateRequest $request)
    {
        JobCategory::create($request->validated());
        return redirect()->route('job-category.index')->with('success', 'Job category created successfully!.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobCategory = JobCategory::findOrFail($id);
        return view('job_category.edit', compact('jobCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobCategoryCreateRequest $request, string $id)
    {
        $jobCategory = JobCategory::findOrFail($id);
        $jobCategory->update($request->validated());
        return redirect()->route('job-category.index')->with('success', 'Job category updated successfully!.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobCategory = JobCategory::findOrFail($id);
        $jobCategory->delete();
        return redirect()->route('job-category.index')->with('success', 'Job category archived successfully!.');
    }

    public function restore(string $id)
    {
        $jobCategory = JobCategory::onlyTrashed()->findOrFail($id);
        $jobCategory->restore();
        return redirect()->route('job-category.index',['archived'=>'true'])->with('success', 'Job category restored successfully!.');
    }
}
