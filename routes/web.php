<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RequestNotificationController;
use App\Http\Controllers\RoomController;
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




// Routes Under Agent
Route::get('/agent', [AgentController::class, 'index'])->name('agentIndex');
Route::get('/agent/create', [AgentController::class, 'agentCreate'])->name('agentCreate');
Route::post('/agent', [AgentController::class, 'agentStore'])->name('agentStore');
Route::get('/agent/{id}/edit', [AgentController::class, 'agentEdit'])->name('agentEdit');
Route::post('/agent/{id}/update', [AgentController::class, 'agentUpdate'])->name('agentUpdate');
Route::post('/agent/{id}/destroy', [AgentController::class, 'agentDestroy'])->name('agentDestroy');





// Routes Under Time
Route::get('/time', [TimeSlotController::class, 'index'])->name('timeIndex');
Route::get('/time/create', [TimeSlotController::class, 'timeCreate'])->name('timeCreate');
Route::post('/time', [TimeSlotController::class, 'timeStore'])->name('timeStore');
Route::get('/time/{id}/edit', [TimeSlotController::class, 'timeEdit'])->name('timeEdit');
Route::post('/time/{id}/update', [TimeSlotController::class, 'timeUpdate'])->name('timeUpdate');
Route::post('/time/{id}/destroy', [TimeSlotController::class, 'timeDestroy'])->name('timeDestroy');





// Routes Under Room
Route::get('/room', [RoomController::class, 'index'])->name('roomIndex');
Route::get('/room/create', [RoomController::class, 'roomCreate'])->name('roomCreate');
Route::post('/room', [RoomController::class, 'roomStore'])->name('roomStore');
Route::get('/room/{id}/edit', [RoomController::class, 'roomEdit'])->name('roomEdit');
Route::post('/room/{id}/update', [RoomController::class, 'roomUpdate'])->name('roomUpdate');
Route::post('/room/{id}/destroy', [RoomController::class, 'roomDestroy'])->name('roomDestroy');





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