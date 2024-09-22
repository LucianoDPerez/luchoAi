<?php

// routes/api.php

use App\Http\Controllers\Api\BlackboxController;
use App\Http\Controllers\Api\GoogleController;
use App\Http\Controllers\AssistantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::group(['middleware' => 'cors'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    // routes/api.php

    Route::post('/whisper', [AssistantController::class, 'whisper']);
    Route::post('/text', [AssistantController::class, '__invoke']);

    Route::post('/alimentos', [AssistantController::class, '__invoke']);


    Route::post('/blackbox', [BlackboxController::class, 'blackbox']);

    Route::post('/google/auth', [GoogleController::class, 'auth']);
    Route::get('/google/create-task', [GoogleController::class, 'createTask']);

});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    // Aquí puedes agregar más rutas protegidas por autenticación
});
