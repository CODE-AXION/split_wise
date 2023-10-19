<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
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

// Route::get('/users', [FriendRequestController::class, 'allUsers'])->middleware('auth')->name('all.users');

Route::middleware(['auth'])->group(function () {

    Route::controller(FriendRequestController::class)->group(function () {
        
        // Friend Request Routes
        Route::get('/create-friend-request', 'createRequest')->name('create.request');
        Route::post('/send-friend-request', 'sendRequest')->name('send.request');
        Route::post('/accept-friend-receiver', 'acceptRequest')->name('accept.request');
    });


    // Settle Up Routes
    Route::prefix('/settle-up')->controller(ExpenseController::class)->group(function () {
        Route::get('/{expense}',  'createSettleUp')->name('create.settle.up.expense');
        Route::post('/pay/{expense}', 'paySettleUp')->name('pay.settle.up.expense');
    });


    Route::prefix('/settle-groups')->controller(ExpenseController::class)->group(function () {
        Route::get('groups/{group?}',  'groupList')->name('group.list.expense');
        Route::get('groups/view/{group?}',  'groupView')->name('groups.view');
        Route::post('settle-pay',[ExpenseController::class,'settleUp'])->name('group.settle.up');
        
        // Route::post('/pay/{expense}', 'paySettleUp')->name('pay.settle.up.expense');
    });

    Route::controller(ExpenseController::class)->group(function () {
        // Expense Routes
        Route::get('/pay-expense','createExpense')->name('create.expense');
        Route::get('/get-expenses','getExpenses')->name('get.expense');
        Route::post('/record-expense','recordExpense')->name('record.expense');
    });

});

Route::fallback(function() {
    return view('pages/utility/404');
});    


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
