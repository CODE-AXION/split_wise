<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\DashboardController;

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



Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/create-friend-request', [FriendRequestController::class, 'createRequest'])->middleware('auth')->name('create.request');
Route::post('/send-friend-request', [FriendRequestController::class, 'sendRequest'])->middleware('auth')->name('send.request');
Route::post('/accept-friend-receiver', [FriendRequestController::class, 'acceptRequest'])->middleware('auth')->name('accept.request');


Route::fallback(function() {
    return view('pages/utility/404');
});    


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
