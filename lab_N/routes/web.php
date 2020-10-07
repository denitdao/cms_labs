<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PageResource;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function(){
    return redirect()->route('pages', ['page_code' => 'home']);
});

Route::resource('page', PageResource::class);

Route::get('/{page_code}/{lang?}', [PageController::class, 'show'])->name('pages');
