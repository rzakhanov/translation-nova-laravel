<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Rzakhanov\Translation\Http\Controllers\Groups;
use Rzakhanov\Translation\Http\Controllers\Languages;
use Rzakhanov\Translation\Http\Controllers\Translation;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/
Route::get('/get', [Translation::class,'all']);
Route::post('/save', [Translation::class,'store']);
Route::put('/update', [Translation::class,'update']);
Route::delete('/delete', [Translation::class,'delete']);

Route::get('/languages/list', [Languages::class,'all']);
Route::post('/languages/save', [Languages::class,'store']);
Route::put('/languages/update', [Languages::class,'update']);
Route::delete('/languages/delete', [Languages::class,'delete']);

Route::get('/groups/list', [Groups::class,'all']);
Route::post('/groups/save', [Groups::class,'store']);
Route::put('/groups/update', [Groups::class,'update']);
Route::delete('/groups/delete', [Groups::class,'delete']);

// Route::get('/', function (Request $request) {
//     //
// });
