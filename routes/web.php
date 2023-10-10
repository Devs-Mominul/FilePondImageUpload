<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


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
Route::get('/',[PostController::class,'welcome']);
Route::post('/postdata',[PostController::class,'store'])->name('store.data');
Route::post('/tempupload',[PostController::class,'tempupload'])->name('filepond.upload');
Route::delete('/tempdelete',[PostController::class,'tempdelete'])->name('filepond.delete');
