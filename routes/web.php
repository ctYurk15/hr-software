<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Views\MyTracker;
use App\Http\Controllers\Views\TeamTracker;
use App\Http\Controllers\Views\MyPersonal;
use App\Http\Controllers\Views\TeamPersonal;
use App\Http\Controllers\Views\VacationsList;
use App\Http\Controllers\Views\SicklistsList;
use App\Http\Controllers\Views\Holidays;
use App\Http\Controllers\Views\TrackerEntryModal;
use App\Http\Controllers\Views\DetailsPersonal;
use App\Http\Controllers\Views\EditPersonal;
use App\Http\Controllers\TrackerAction;
use App\Http\Controllers\PersonalAction;
use App\Http\Controllers\VacationAction;
use App\Http\Controllers\SicklistAction;

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
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return redirect()->route('login');
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
Route::post('/change-personal-password/{user_id}', [PersonalAction::class, 'changePassword'])->middleware(['auth'])->name('change-personal-password');

Route::get('/vacations', [VacationsList::class, 'view'])->middleware(['auth'])->name('my-vacation');
Route::get('/get-vacation/{vacation_id}', [VacationAction::class, 'get'])->middleware(['auth'])->name('get-vacation');
Route::post('/save-vacation', [VacationAction::class, 'save'])->middleware(['auth'])->name('save-vacation');
Route::post('/delete-vacation/{vacation_id}', [VacationAction::class, 'delete'])->middleware(['auth'])->name('delete-vacation');

Route::get('/sicklists', [SicklistsList::class, 'view'])->middleware(['auth'])->name('sicklists');
Route::get('/get-sicklist/{sicklist_id}', [SicklistAction::class, 'get'])->middleware(['auth'])->name('get-sicklist');
Route::post('/save-sicklist', [SicklistAction::class, 'save'])->middleware(['auth'])->name('save-sicklist');
Route::post('/delete-sicklist/{sicklist_id}', [SicklistAction::class, 'delete'])->middleware(['auth'])->name('delete-sicklist');

Route::get('/holidays', [Holidays::class, 'view'])->middleware(['auth'])->name('holidays');

require __DIR__.'/auth.php';
