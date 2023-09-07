<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RequestController;
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
     * Only allow access to users that belong to Solido Connecting Solutions.
     */
    Route::middleware(['solidocs'])->group(function() {

        // Documents index.
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

        // Users list.
        Route::get('/users', [UserController::class, 'index'])->name('users');

        // Create user.
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

        // Store user in database.
        Route::post('/users/save', [UserController::class, 'store'])->name('users.save');

        // View user.
        Route::get('/users/{id}', [UserController::class, 'view'])->name('users.view');

        // Delete user.
        Route::get('/users/delete/{id}', [UserController::class, 'delete'])->name('users.delete');

        // View requests.
        Route::get('/requests', [RequestController::class, 'index'])->name('requests');

        // Store request in database.
        Route::post('/request/store', [RequestController::class, 'store'])->name('requests.store');

        // View request.
        Route::get('/requests/{id}', [RequestController::class, 'view'])->name('requests.view');
    });
});
