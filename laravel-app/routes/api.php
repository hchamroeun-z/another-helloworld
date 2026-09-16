<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GoogleOAuthController;
use Illuminate\Support\Facades\Route;

route::post('/signup',[AuthController::class,'signup']);
route::post('/signin',[AuthController::class,'signin']);
Route::get('/verify/email/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware('signed')
    ->name('verify.email');

Route::post('/send/verification-email', [AuthController::class, 'sendVerificationEmail']);
Route::post('/send/reset-password-email', [AuthController::class, 'sendResetPasswordEmail']);
Route::post('/set/new-password', [AuthController::class, 'setNewPassword'])->name('set.new-password');

Route::prefix('google')->group(function () {
    Route::get('/oauth/redirect', [GoogleOAuthController::class, 'googleOAuthRedirect']);
    Route::get('/oauth/callback', [GoogleOAuthController::class, 'googleOAuthCallback']);
    Route::post('/oauth/exchange/token', [GoogleOAuthController::class, 'googleOAuthExchangeToken'])->middleware('auth:sanctum');
});

route::middleware('auth:sanctum')->group (function(){
    route::post('/signout',[AuthController::class,'signout']);
    route::get('/verify',[AuthController::class,'verify']);
});
