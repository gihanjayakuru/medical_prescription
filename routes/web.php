<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\DashboardController;

// Redirect root URL based on authentication and role
Route::get('/', function () {
    if (Auth::check()) {
        // Redirect based on the user's role
        if (Auth::user()->role === 'pharmacy') {
            return redirect()->route('pharmacy.index'); // Redirect pharmacy user to their dashboard
        } elseif (Auth::user()->role === 'user') {
            return redirect()->route('user.prescriptions'); // Redirect regular user to their prescriptions
        } else {
            // If no recognized role, log out the user and redirect to login
            Auth::logout();
            return redirect()->route('login')->with('error', 'Unauthorized access');
        }
    }

    // If not authenticated, redirect to the login page
    return redirect()->route('login');
});

// User Authentication Routes (Laravel's built-in authentication)
Auth::routes();

// Routes for authenticated users only
Route::middleware(['auth'])->group(function () {

    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Routes
    Route::prefix('user')->name('user.')->group(function () {
        // Route to show the form to upload a prescription
        Route::get('upload-prescription', [PrescriptionController::class, 'create'])->name('uploadPrescription');
        // Route to store the uploaded prescription
        Route::post('upload-prescription', [PrescriptionController::class, 'store'])->name('storePrescription');
        // Route to show the list of user's prescriptions
        Route::get('prescriptions', [PrescriptionController::class, 'index'])->name('prescriptions');
        // Route to show a specific prescription
        Route::get('prescription/{id}', [PrescriptionController::class, 'show'])->name('showPrescription');
        // Route to delete a prescription
        Route::delete('prescription/{id}', [PrescriptionController::class, 'destroy'])->name('destroyPrescription');
        // Route to view the list of quotations for the user
        Route::get('user/quotations', [UserController::class, 'showQuotations'])->name('user.quotations');
        // Route to respond (accept/reject) a quotation
        Route::post('user/quotation/respond/{quotation}', [UserController::class, 'respondToQuotation'])->name('user.respondToQuotation');
    });

    // Pharmacy Routes
    Route::prefix('pharmacy')->name('pharmacy.')->group(function () {
        // Route to view all prescriptions for pharmacy users
        Route::get('prescriptions', [PharmacyController::class, 'index'])->name('index');
        // Route to show the form to create a quotation for a prescription
        Route::get('create_quotation/{prescription}', [QuotationController::class, 'create'])->name('createQuotation');
        // Route to store the created quotation
        Route::post('store-quotation/{prescription}', [PharmacyController::class, 'storeQuotation'])->name('storeQuotation');
        // Route to show a specific quotation for the pharmacy user
        Route::get('quotation/{id}', [QuotationController::class, 'show'])->name('showQuotation');
    });
});
