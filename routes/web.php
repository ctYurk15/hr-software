<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Views\MyTracker;
use App\Http\Controllers\Views\TeamTracker;
use App\Http\Controllers\Views\MyPersonal;
use App\Http\Controllers\Views\TeamPersonal;
use App\Http\Controllers\Views\MyVacation;
use App\Http\Controllers\Views\TeamVacation;
use App\Http\Controllers\Views\MySicklist;
use App\Http\Controllers\Views\TeamSicklist;
use App\Http\Controllers\Views\Holidays;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/my-tracker', [MyTracker::class, 'view'])->middleware(['auth'])->name('my-tracker');
Route::get('/team-tracker', [TeamTracker::class, 'view'])->middleware(['auth'])->name('team-tracker');

Route::get('/my-personal', [MyPersonal::class, 'view'])->middleware(['auth'])->name('my-personal');
Route::get('/team-personal', [TeamPersonal::class, 'view'])->middleware(['auth'])->name('team-personal');

Route::get('/my-vacation', [MyVacation::class, 'view'])->middleware(['auth'])->name('my-vacation');
Route::get('/team-vacation', [TeamVacation::class, 'view'])->middleware(['auth'])->name('team-vacation');

Route::get('/my-sicklist', [MySicklist::class, 'view'])->middleware(['auth'])->name('my-sicklist');
Route::get('/team-sicklist', [TeamSicklist::class, 'view'])->middleware(['auth'])->name('team-sicklist');

Route::get('/holidays', [Holidays::class, 'view'])->middleware(['auth'])->name('holidays');

require __DIR__.'/auth.php';
