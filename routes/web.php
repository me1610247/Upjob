<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JobController as JobAdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\Admin\JobApplicationController;
use App\Http\Controllers\ForgetPassword;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\JobHomeController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\AuthenticateMiddleware;
use App\Http\Middleware\CheckAdmin;
//Route::get('/', function () {
  //  return view('welcome');
//});

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/jobs',[JobHomeController::class,'index'])->name('jobs');
Route::get('/jobs/details/{id}',[JobController::class,'details'])->name('details');
Route::post('/apply-job', [JobController::class, 'applyJob'])->name('applyJob');
Route::post('/save-job',[JobController::class,'favJob'])->name('favJob');

// RedirectIfAuthenticated middleware that prevent redirect to login or register after logged in

Route::middleware([RedirectIfAuthenticated::class])->group(function () {
Route::get('/auth/register',[AuthController::class,'Registeration'])->name('account.register');
Route::post('/auth/register-Process',[AuthController::class,'RegisterProcess'])->name('account.RegisterProcess');
Route::get('/auth/login',[AuthController::class,'login'])->name('account.login');
Route::get('/auth/forget-password',[ForgetPassword::class,'forgetPassword'])->name('account.forgetPassword');
Route::post('/auth/forget-password',[ForgetPassword::class,'forgetPasswordPost'])->name('account.forgetPasswordPost');
Route::get('/auth/reset-password/{token}',[ForgetPassword::class,'resetPassword'])->name('account.resetPassword');
Route::post('/auth/reset-password',[ForgetPassword::class,'resetPasswordPost'])->name('account.resetPasswordPost');
Route::post('/auth/authenticate',[AuthController::class,'authenticate'])->name('account.authenticate');
});

// AuthenticateMiddleware prevent redirect to profile page until logged in first 
Route::middleware([CheckAdmin::class])->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
  Route::get('/users', [UserController::class, 'index'])->name('admin.users');
  Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('admin.edit');
  Route::put('/users/update/{id}', [UserController::class, 'update'])->name('admin.update');
  Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.destroy');
  Route::get('/admin/jobs', [JobAdminController::class, 'index'])->name('admin.jobs');
  Route::get('/admin/jobs/edit/{id}', [JobAdminController::class, 'edit'])->name('admin.jobs.edit');
  Route::put('/admin/jobs/update/{id}', [JobAdminController::class, 'update'])->name('admin.jobs.update');
  Route::delete('/admin/jobs/{id}', [JobAdminController::class, 'destroy'])->name('admin.jobs.destroy');
  Route::get('/admin/job-applications', [JobApplicationController::class, 'index'])->name('admin.applications');
  Route::delete('/admin/jobs-applications/{id}', [JobApplicationController::class, 'destroy'])->name('admin.applications.destroy');

});
Route::middleware([AuthenticateMiddleware::class])->group(function () {
  Route::get('/auth/profile', [AuthController::class, 'profile'])->name('account.profile');
  Route::get('/auth/notification', [NotificationController::class, 'notification'])->name('account.notification');
  Route::put('/auth/update-profile', [AuthController::class, 'updateProfile'])->name('account.updateProfile');
  Route::get('/auth/logout',[AuthController::class,'logout'])->name('account.logout');
  Route::post('/auth/update-pic',[AuthController::class,'updateProfilePic'])->name('account.updateProfilePic');
  Route::get('/auth/create-job',[JobController::class,'createJob'])->name('account.createJob');
  Route::post('/auth/save-job',[JobController::class,'saveJob'])->name('account.saveJob');
  Route::get('/auth/my-jobs',[JobController::class,'myJobs'])->name('account.myJobs');
  Route::get('/auth/my-jobs/edit/{jobId}',[JobController::class,'editJob'])->name('account.editJob');
  Route::post('/auth/update-job/{jobId}',[JobController::class,'updateJob'])->name('account.updateJob');
  Route::post('/auth/delete-job',[JobController::class,'deleteJob'])->name('account.deleteJob');
  Route::get('/auth/applied-job',[JobController::class,'myAppliedJobs'])->name('account.myAppliedJobs');
  Route::get('/auth/saved-job',[JobController::class,'savedJobs'])->name('account.savedJobs');
  Route::post('/auth/unsave-job',[JobController::class,'unSaveJobs'])->name('account.unSaveJobs');
  Route::post('/auth/update-password',[AuthController::class,'updatePassword'])->name('account.updatePassword');
  Route::get('/jobs/applied', [JobController::class, 'showAppliedJobs'])->name('jobs.applied');

});
