<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RequestNotificationController;
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