<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Livewire\Features\SupportFileUploads\FileUploadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\WelcomeController::class, 'index']);

/*Route::get('/', function () {
    return view('welcome');
});*/


Route::get('/phpinfo', function () {
    return phpinfo();
});


Route::post('/livewire/upload-file', [\App\Helpers\FileUploadController::class, 'handle'])
    ->name('livewire.upload-file')
    ->middleware('web');
