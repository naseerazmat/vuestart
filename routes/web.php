<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('master', [HomeController::class, "index"]);
// Route::get('{path}', [HomeController::class, "index"])->where('path', '([A-z\d-\/_.]+)?');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// For clearing log files from logs directive
Artisan::command('logs:clear', function() {
    array_map('unlink', array_filter((array) glob(storage_path('logs/*.log'))));
    $this->comment('Logs have been cleared!');
 })->describe('Clear log files');