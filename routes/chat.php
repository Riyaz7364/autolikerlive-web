<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatAdminController;

/*
|--------------------------------------------------------------------------
| Live Chat Routes (guest -> admin only)
| Guest APIs are throttled. Admin routes reuse the existing `admin` middleware.
|--------------------------------------------------------------------------
*/

Route::prefix('api/chat')->name('chat.')->group(function () {
    Route::post('/start', [ChatController::class, 'start'])->middleware('throttle:20,1')->name('start');
    Route::post('/send', [ChatController::class, 'send'])->middleware('throttle:30,1')->name('send');
    Route::post('/poll', [ChatController::class, 'poll'])->middleware('throttle:60,1')->name('poll');
    Route::get('/status', [ChatController::class, 'status'])->name('status');
});

Route::middleware('admin')->prefix('admin/chats')->name('admin.chats.')->group(function () {
    Route::get('/', [ChatAdminController::class, 'index'])->name('index');
    Route::get('/unread', [ChatAdminController::class, 'unread'])->name('unread');
    Route::get('/{uuid}', [ChatAdminController::class, 'show'])->name('show');
    Route::post('/{uuid}/reply', [ChatAdminController::class, 'reply'])->name('reply');
    Route::post('/{uuid}/status', [ChatAdminController::class, 'setStatus'])->name('status');
    Route::post('/{uuid}/note', [ChatAdminController::class, 'note'])->name('note');
    Route::post('/{uuid}/block', [ChatAdminController::class, 'block'])->name('block');
    Route::post('/{uuid}/unblock', [ChatAdminController::class, 'unblock'])->name('unblock');
    Route::delete('/{uuid}', [ChatAdminController::class, 'destroy'])->name('destroy');
    Route::get('/{uuid}/export', [ChatAdminController::class, 'export'])->name('export');
});
