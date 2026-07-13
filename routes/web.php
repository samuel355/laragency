<?php

use App\Http\Controllers\AdminParcelController;
use App\Http\Controllers\AdminContentController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminFaqController;
use App\Http\Controllers\AdminListingController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminRequestController;
use App\Http\Controllers\AdminServiceController;
use App\Http\Controllers\AdminTeamMemberController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\MortgageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ParcelController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SiteVisitController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::middleware(['guest', 'throttle:5,1'])->group(function (): void {
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});
Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/services/{service:slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'storeContact'])->name('contact.store');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/site-visits/book', [SiteVisitController::class, 'create'])->name('site-visits.create');
Route::post('/site-visits/book', [SiteVisitController::class, 'store'])->name('site-visits.store');

Route::get('/mortgage-inquiry', [MortgageController::class, 'create'])->name('mortgage.create');
Route::post('/mortgage-inquiry', [MortgageController::class, 'store'])->name('mortgage.store');

Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
Route::get('/listings/{listing:slug}', [ListingController::class, 'show'])->name('listings.show');
Route::post('/listings/{listing:slug}/inquire', [ListingController::class, 'inquire'])->name('listings.inquire');
Route::get('/team', [TeamController::class, 'index'])->name('team.index');
Route::get('/team/{member:slug}', [TeamController::class, 'show'])->name('team.show');

Route::get('/parcels', [ParcelController::class, 'index'])->name('parcels.index');
Route::get('/parcels/{parcel}', [ParcelController::class, 'show'])->name('parcels.show');
Route::get('/parcels/{parcel}/checkout', [CheckoutController::class, 'show'])->name('parcels.checkout.show');
Route::post('/parcels/{parcel}/checkout', [CheckoutController::class, 'store'])->name('parcels.checkout.store');
Route::get('/payments/callback', [PaymentController::class, 'callback'])->name('payments.callback');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function (): void {
    Route::redirect('/', '/admin/dashboard');
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
    Route::resource('content', AdminContentController::class)->only(['index', 'edit', 'update']);
    Route::resource('listings', AdminListingController::class)->except(['show', 'destroy']);
    Route::resource('services', AdminServiceController::class)->except(['show', 'destroy']);
    Route::resource('team', AdminTeamMemberController::class)->except(['show', 'destroy']);
    Route::resource('faqs', AdminFaqController::class)->except(['show', 'destroy']);
    Route::resource('parcels', AdminParcelController::class)->except(['show', 'destroy']);
    Route::get('/requests', [AdminRequestController::class, 'index'])->name('requests.index');
    Route::delete('/requests/{type}/{id}', [AdminRequestController::class, 'destroy'])->name('requests.destroy');
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
});
