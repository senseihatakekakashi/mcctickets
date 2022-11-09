<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RequestNotificationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;





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

Auth::routes(['register' => false]);
// Auth::routes();




// Routes Under Time
Route::get('/time-slot', [TimeSlotController::class, 'index'])->name('timeSlotIndex');
Route::get('/time-slot/create', [TimeSlotController::class, 'create'])->name('timeSlotCreate');
Route::post('/time-slot', [TimeSlotController::class, 'store'])->name('timeSlotStore');
Route::get('/time-slot/{id}/edit', [TimeSlotController::class, 'edit'])->name('timeSlotEdit');
Route::post('/time-slot/{id}/update', [TimeSlotController::class, 'update'])->name('timeSlotUpdate');
Route::post('/time-slot/{id}/destroy', [TimeSlotController::class, 'destroy'])->name('timeSlotDestroy');





// Routes Under Room
Route::get('/room', [RoomController::class, 'index'])->name('roomIndex');
Route::get('/room/create', [RoomController::class, 'create'])->name('roomCreate');
Route::post('/room', [RoomController::class, 'store'])->name('roomStore');
Route::get('/room/{id}/edit', [RoomController::class, 'edit'])->name('roomEdit');
Route::put('/room/{id}/update', [RoomController::class, 'update'])->name('roomUpdate');
Route::delete('/room/{id}/destroy', [RoomController::class, 'destroy'])->name('roomDestroy');

Route::get('/get-all-rooms-data', [RoomController::class, 'getAllRoomsData'])->name('getAllRoomsData');





// Routes Under Slot
Route::get('/slot', [SlotController::class, 'index'])->name('slotIndex');
Route::get('/slot/create', [SlotController::class, 'create'])->name('slotCreate');
Route::post('/slot', [SlotController::class, 'store'])->name('slotStore');
Route::get('/slot/{id}/edit', [SlotController::class, 'edit'])->name('slotEdit');
Route::put('/slot/{id}/update', [SlotController::class, 'update'])->name('slotUpdate');
Route::delete('/slot/{id}/destroy', [SlotController::class, 'destroy'])->name('slotDestroy');





// Routes Under Auth
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/get-request-notification', [RequestNotificationController::class, 'getRequestNotification'])->name('getRequestNotification');
Route::get('mark-all-as-read', [RequestNotificationController::class, 'markAllAsRead'])->name('markAllAsRead');
Route::get('mark-as-read/{id}', [RequestNotificationController::class, 'markAsRead'])->name('markAsRead');





// Route for User Level Access
Route::resource('/user-role', UserRoleController::class);





// Public Route for Adding new User
Route::resource('/system-user', UserController::class);
Route::post('/system-user/{id}/deactivate', [UserController::class, 'deactivate'])->name('system-user.deactivate');
Route::post('/system-user/{id}/reset', [UserController::class, 'resetPassword'])->name('system-user.reset');





Route::get('/change-password', [UserController::class, 'changePassword'])->name('changePassword');
Route::post('/change-password', [UserController::class, 'changePasswordStore'])->name('changePasswordStore');





Route::resource('/audit-trail', AuditController::class);