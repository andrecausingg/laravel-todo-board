<?php

use App\Http\Controllers\V1\System\Users\UserAuthenticationController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('register', [UserAuthenticationController::class, 'registerController']);
    Route::post('login', [UserAuthenticationController::class, 'loginController']);

    // Protected routes under JWT (middleware alias 'scope')
    Route::middleware('jwtMiddleware')->prefix('todo')->group(function () {
        Route::get('/test-api', function () {
            return response()->json([
                'message' => 'API is working.'
            ]);
        });
    });
});
