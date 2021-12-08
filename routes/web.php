<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TagsController;
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

// Example Routes
Route::view('/', 'landing')->name('home');
Route::match(['get', 'post'], '/dashboard', function(){
    return view('dashboard');
});

Route::middleware([ /*'auth:sanctum', 'verified'*/])->prefix('admin')->group(function() {
//    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');
//    Route::get('tags', [TagsController::class, 'index'])->name('admin.tags.index');

    Route::get('/tags_filter/{page?}', [TagsController::class, 'getFilteredAjax'])->name('TagsGetFilter');
    Route::resource('/tags', TagsController::class);

});

Route::view('/pages/slick', 'pages.slick');
Route::view('/pages/datatables', 'pages.datatables');
Route::view('/pages/blank', 'pages.blank');
