<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Tour;
use App\Models\Booking;

// 1. Trang chủ & Tìm kiếm Tour
Route::get('/', function (Request $request) {
    $query = Tour::query();

    if ($request->filled('location')) {
        $query->where('location', 'like', '%' . $request->location . '%');
    }
    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }
    if ($request->filled('duration')) {
        $query->where('duration', $request->duration);
    }

    $tours = $query->get();
    return view('welcome', compact('tours'));
})->name('home');

// 2. Trang Xem chi tiết Tour
Route::get('/tour/{id}', function ($id) {
    $tour = Tour::findOrFail($id);
    return view('tours.show', compact('tour'));
})->name('tours.show');

// 3. Lịch sử đặt tour (Trang Dashboard User)
Route::get('/dashboard', function () {
    $bookings = Booking::where('user_id', Auth::id())->with('tour')->latest()->get();
    return view('dashboard', compact('bookings'));
})->middleware(['auth', 'verified'])->name('dashboard');

// 4. Các chức năng yêu cầu đăng nhập
Route::middleware('auth')->group(function () {
    Route::post('/book-tour/{id}', [BookingController::class, 'store'])->name('book.tour');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 5. CHỨC NĂNG QUẢN TRỊ VIÊN (ADMIN)
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    
    // Danh mục
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::delete('/categories/{id}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');
    
    // Tour
    Route::post('/tours', [AdminController::class, 'storeTour'])->name('tours.store');
    Route::delete('/tours/{id}', [AdminController::class, 'destroyTour'])->name('tours.destroy');
    
    // Đơn đặt & User
    Route::post('/bookings/{id}', [AdminController::class, 'updateBooking'])->name('bookings.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');
});

require __DIR__.'/auth.php';