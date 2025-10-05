<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;

/*
|--------------------------------------------------------------------------
| App Routes
|--------------------------------------------------------------------------
|
| Here are the routes for the app functionality including RajeLiker,
| Facebook login, permissions, and API endpoints.
|
*/

// Main App Routes
Route::prefix('app')->name('app.')->group(function () {

    // RajeLiker Routes
    Route::get('/rajeliker', [AppController::class, 'rajeliker'])->name('index');
    Route::get('/dashboard', [AppController::class, 'rajeliker'])->name('dashboard');
    Route::get('/login', [AppController::class, 'redirectToFacebook'])->name('facebook.login');
    Route::get('rajeliker/callback', [AppController::class, 'handleFacebookCallback'])->name('facebook.callback');
    Route::post('/facebook/process-token', [AppController::class, 'processFacebookToken'])->name('facebook.process');
    Route::get('/logout', [AppController::class, 'facebookLogout'])->name('facebook.logout');
    Route::get('/status', [AppController::class, 'getLoginStatus'])->name('status');
    // Permission Screen
    Route::get('/permission', [AppController::class, 'permission'])->name('permission');
    // AutoLiker Routes (for EAAF tokens)
    Route::get('/autoliker', [AppController::class, 'autolikerDashboard'])->name('autoliker');
    Route::post('/autoliker/submit-reaction', [AppController::class, 'submitAutoLikerReaction'])->name('autoliker.reaction');
    Route::get('/autoliker/stats', [AppController::class, 'getAutoLikerStats'])->name('autoliker.stats');

    // Health Check
    // Route::get('/', [AppController::class, 'healthCheck'])->name('health');

    // Facebook Analytics API Routes
    Route::get('/api/facebook/profile', [AppController::class, 'getFacebookProfile'])->name('facebook.profile');
    Route::get('/api/facebook/pages', [AppController::class, 'getFacebookPages'])->name('facebook.pages');
    Route::get('/api/facebook/posts', [AppController::class, 'getPostInsights'])->name('facebook.posts');

    // Save Token in Storage
    Route::post('/autoliker/saveCredits', [AppController::class, 'saveCredits'])->name('autoliker.saveCredits');



    Route::get('makeSession', [AppController::class, 'makeSession']);
});
