<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
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

/**
 * If the user is authenticated, he will be directed to "home",
 * otherwise to "login".
 */
Route::get('/', function() {
    return to_route('home');
})->middleware('auth');

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

/**
 * Authentication routes.
 */
Route::name('auth.')->group(function () {
    Route::get('/login', [LoginController::class, 'view'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.user');
    Route::get('/register', [RegisterController::class, 'view'])->name('register');
    Route::post('/register', [RegisterController::class, 'create'])->name('register.user');
    Route::get('/verification/{token}', [RegisterController::class, 'verify'])->name('verify');
});

/**
 * Routes that only authenticated users can access.
 */
Route::middleware('auth')->group(function() {

    /**
     * Logout.
     */
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    /**
     * Documents.
     */
    Route::get('/documents', [DocumentController::class, 'index'])->name('documents');

    // Create document.
    Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');

    // Store documents in database.
    Route::post('/documents/store', [DocumentController::class, 'store'])->name('documents.store');

    // View document.
    Route::get('/documents/{id}', [DocumentController::class, 'view'])->name('documents.view');

    // Download document.
    Route::get('/documents/download/{id}', [DownloadController::class, 'download_document'])->name('documents.download');

    // Delete document.
    Route::get('/documents/delete/{id}', [DocumentController::class, 'delete'])->name('documents.delete');

    // Edit document.
    Route::post('/documents/edit/{id}', [DocumentController::class, 'edit'])->name('documents.edit');
});
