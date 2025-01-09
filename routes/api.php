<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('clients')->group(function () {
    Route::post('/', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/{id}', [ClientController::class, 'show'])->name('clients.show');
    Route::put('/{id}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
});

Route::prefix('transactions')->group(function () {
    Route::get('/getTransactionsByClientId/{id}', [TransactionController::class, 'getTransactionsByClientId'])->name('transactions.getTransactionsByClientId');
    Route::post('/deleteTransactionsByClientId/{id}', [TransactionController::class, 'deleteTransactionsByClientId'])->name('transactions.deleteTransactionsByClientId');
    
    Route::post('/', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::put('/{id}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
});
