<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query=Company::latest();
        if (request()->has('archived')) {
            $query->onlyTrashed();
        }
        $companies = $query->paginate(9)->onEachSide(1);
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = ['Technology', 'Finance', 'Healthcare', 'Education', 'Retail', 'Manufacturing', 'Transportation', 'Energy', 'Entertainment', 'Real Estate'];
        return view('company.create', compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest $request)
    {
        $validatedData = $request->validated();
        $owner=User::create([
            'name'=>$validatedData['owner_name'],
            'email'=>$validatedData['owner_email'],
            'role'=>'company-owner',
            'password'=>Hash::make($validatedData['owner_password']),
        ]);
        if(!$owner){
            return redirect()->route('companies.create')->with('error','Failed to create company owner. Please try again.');
        }
        Company::create([
            'name'=>$validatedData['name'],
            'address'=>$validatedData['address'],
            'industry'=>$validatedData['industry'],
            'website'=>$validatedData['website'] ?? null,
            'ownerId'=>$owner->id,
        ]);
        return redirect()->route('companies.index')->with('success', 'Company created successfully!.');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company=Company::findOrFail($id);
        return view('company.show',compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company=Company::findOrFail($id);
        $industries = ['Technology', 'Finance', 'Healthcare', 'Education', 'Retail', 'Manufacturing', 'Transportation', 'Energy', 'Entertainment', 'Real Estate'];
        return view('company.edit',compact('company'),compact('industries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $company = Company::findOrFail($id);
        $company->update([
            'name'=>$validatedData['name'],
            'address'=>$validatedData['address'],
            'industry'=>$validatedData['industry'],
            'website'=>$validatedData['website'] ?? null,
        ]);
        $owner = $company->owner;
        $owner->update([
            'name'=>$validatedData['owner_name'],
        ]);
        if($validatedData['owner_password']){
            $owner->update([
                'password'=>Hash::make($validatedData['owner_password']),
            ]);
        }
        return redirect()->route('companies.show', $company->id)->with('success', 'Company updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {   
    $company = Company::findOrFail($id);
    $company->delete();

    return redirect()->route('companies.index')
        ->with('success', 'Company archived successfully!');
    }
    public function restore(string $id)
    {
        $company=Company::withTrashed()->findOrFail($id);
        $company->restore();
        return redirect()->route('companies.index')->with('success','Company restored successfully');
    }
}
