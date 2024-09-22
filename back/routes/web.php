<?php

use App\Http\Controllers\OpenAIController;
use App\Http\Controllers\RecordingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// routes/web.php

Route::get('/chat', [\App\Http\Controllers\AssistantController::class, 'testView'])->name('chat');
Route::post('/test', [\App\Http\Controllers\AssistantController::class, 'test'])->name('test');



Route::post('/recordings', [RecordingController::class, 'store']);

Route::get('/openai', [OpenAIController::class, 'index'])->name('openai.index');
Route::post('/openai/chat', [OpenAIController::class, 'chat'])->name('openai.chat');

//Route::get('/claude', [\App\Http\Controllers\ClaudeController::class, 'index'])->name('claude.index');

Route::get('/maps', [\App\Http\Controllers\GoogleMapsController::class, 'test'])->name('maps.index');

Route::get('/waapi', [\App\Http\Controllers\WhatsappController::class, 'receive']);