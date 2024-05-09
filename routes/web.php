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
use App\Http\Controllers\Views\TrackerEntryModal;
use App\Http\Controllers\Views\DetailsPersonal;
use App\Http\Controllers\Views\EditPersonal;
use App\Http\Controllers\TrackerAction;
use App\Http\Controllers\PersonalAction;

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
Route::post('/tracker-action/{action}', [TrackerAction::class, 'process'])->name('tracker-action');
Route::get('/tracker-entry-modal', [TrackerEntryModal::class, 'view'])->name('tracker-entry-modal');

Route::get('/my-personal', [MyPersonal::class, 'view'])->middleware(['auth'])->name('my-personal');
Route::get('/team-personal', [TeamPersonal::class, 'view'])->middleware(['auth'])->name('team-personal');
Route::get('/details-personal/{user}', [DetailsPersonal::class, 'view'])->middleware(['auth'])->name('details-personal');
Route::get('/edit-personal/{user?}', [EditPersonal::class, 'view'])->middleware(['auth'])->name('edit-personal');
Route::post('/edit-personal/{user?}', [EditPersonal::class, 'view'])->middleware(['auth'])->name('edit-personal');
Route::post('/save-personal', [PersonalAction::class, 'save'])->middleware(['auth'])->name('save-personal');
Route::post('/delete-personal/{user_id}', [PersonalAction::class, 'delete'])->middleware(['auth'])->name('delete-personal');

Route::get('/my-vacation', [MyVacation::class, 'view'])->middleware(['auth'])->name('my-vacation');
Route::get('/team-vacation', [TeamVacation::class, 'view'])->middleware(['auth'])->name('team-vacation');

Route::get('/my-sicklist', [MySicklist::class, 'view'])->middleware(['auth'])->name('my-sicklist');
Route::get('/team-sicklist', [TeamSicklist::class, 'view'])->middleware(['auth'])->name('team-sicklist');

Route::get('/holidays', [Holidays::class, 'view'])->middleware(['auth'])->name('holidays');

require __DIR__.'/auth.php';
