<?php

use App\Http\Controllers\Admin\AnalyticsAdminController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ContactAdminController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ExperienceAdminController;
use App\Http\Controllers\Admin\ProjectAdminController;
use App\Http\Controllers\Admin\ResumeAdminController;
use App\Http\Controllers\Admin\SettingAdminController;
use App\Http\Controllers\Admin\SkillAdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Rohit Verma Portfolio
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/experience', [ExperienceController::class, 'index'])->name('experience');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/resume/download', [ResumeController::class, 'download'])->name('resume.download');

// Analytics Tracking & Opt-out Routes
Route::post('/track', [TrackController::class, 'track'])->middleware('throttle:60,1')->name('track');
Route::post('/track/opt-out', [TrackController::class, 'optOut'])->name('track.opt-out');

// Admin Authentication Routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Protected Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [AnalyticsAdminController::class, 'index'])->name('analytics.index');

    // Projects CRUD
    Route::resource('projects', ProjectAdminController::class)->except(['show']);

    // Skills CRUD & Management
    Route::resource('skills', SkillAdminController::class)->except(['show']);
    Route::patch('/skills/{skill}/toggle', [SkillAdminController::class, 'toggle'])->name('skills.toggle');
    Route::post('/skills/reorder', [SkillAdminController::class, 'reorder'])->name('skills.reorder');

    // Experience CRUD
    Route::resource('experiences', ExperienceAdminController::class)->except(['show']);

    // Resume Manager
    Route::get('/resume', [ResumeAdminController::class, 'index'])->name('resume.index');
    Route::post('/resume/upload', [ResumeAdminController::class, 'upload'])->name('resume.upload');
    Route::post('/resume/{resume}/set-active', [ResumeAdminController::class, 'setActive'])->name('resume.set-active');
    Route::delete('/resume/{resume}', [ResumeAdminController::class, 'destroy'])->name('resume.destroy');

    // Site Settings (Hero, Profile Image, SEO, Social, Footer)
    Route::get('/settings', [SettingAdminController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingAdminController::class, 'update'])->name('settings.update');

    // Messages Inbox
    Route::get('/contacts', [ContactAdminController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [ContactAdminController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{contact}', [ContactAdminController::class, 'destroy'])->name('contacts.destroy');

    // Profile & Password
    Route::get('/profile', [SettingAdminController::class, 'profile'])->name('profile');
    Route::post('/profile', [SettingAdminController::class, 'updateProfile'])->name('profile.update');
});
