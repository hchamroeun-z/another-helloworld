<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

route::post('/signup',[AuthController::class,'signup']);
route::post('/signin',[AuthController::class,'signin']);

route::middleware('auth:sanctum')->group (function(){
    route::post('/signout',[AuthController::class,'signout']);
    route::get('/verify',[AuthController::class,'verify']);
});
