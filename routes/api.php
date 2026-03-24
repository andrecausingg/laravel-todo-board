<?php

use App\Http\Controllers\V1\System\Todo\TodoController;
use App\Http\Controllers\V1\System\Users\UserAuthenticationController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('register', [UserAuthenticationController::class, 'registerController']);
    Route::post('login', [UserAuthenticationController::class, 'loginController']);

    Route::middleware('jwtMiddleware')->group(function () {
        Route::prefix('todo')->group(function () {
            Route::get('/', [TodoController::class, 'indexTodoController']);
            Route::post('/', [TodoController::class, 'storeTodoController']);
            Route::get('/{id}', [TodoController::class, 'showTodoController']);
            Route::match(['put', 'patch'], '/{id}', [TodoController::class, 'updateTodoController']);
            Route::delete('/{id}', [TodoController::class, 'destroyTodoController']);

            Route::get('/test-api', function () {
                return response()->json([
                    'message' => 'API is working.'
                ]);
            });
        });

        // Settings routes
        Route::prefix('settings')->group(function () {
            Route::get('logout', [UserAuthenticationController::class, 'logoutController']);
        });
    });
});
