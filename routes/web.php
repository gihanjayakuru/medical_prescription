<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\PrescriptionController;
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
    // User routes
    Route::get('/user/upload-prescription', [PrescriptionController::class, 'create'])->name('user.uploadPrescription');
    Route::post('/user/upload-prescription', [PrescriptionController::class, 'store'])->name('user.storePrescription');
    Route::get('/user/quotations', [UserController::class, 'quotations'])->name('user.quotations');
    Route::post('/user/respond-quotation/{quotation}', [UserController::class, 'respondToQuotation'])->name('user.respondToQuotation');

    // Pharmacy routes
    Route::get('/pharmacy/prescriptions', [PharmacyController::class, 'index'])->name('pharmacy.index');
    Route::get('/pharmacy/create-quotation/{prescription}', [PharmacyController::class, 'createQuotation'])->name('pharmacy.createQuotation');
    Route::post('/pharmacy/store-quotation/{prescription}', [PharmacyController::class, 'storeQuotation'])->name('pharmacy.storeQuotation');
});
