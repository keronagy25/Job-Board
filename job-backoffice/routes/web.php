<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    //users
    Route::resource('users', UserController::class);
    //companies
    Route::resource('companies', CompanyController::class);
    Route::post('companies/{id}/restore', [CompanyController::class, 'restore'])->name('companies.restore');
    //job applications
    Route::resource('job-applications', JobApplicationController::class);
    //job categories
    Route::resource('job-categories', JobCategoryController::class);
    Route::post('job-categories/{id}/restore', [JobCategoryController::class, 'restore'])->name('job-categories.restore');
    //job vacancies
    Route::resource('job-vacancies', JobVacancyController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
