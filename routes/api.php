<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::middleware('auth')->group(function () {
    Route::get('hotel', [HotelController::class, 'index'])->name('hotel.index');
    Route::get('hotel/{hotel_id}', [HotelController::class, 'show'])->name('hotel.show');
    Route::middleware('role:admin')->group(function () {
        Route::post('hotel', [HotelController::class, 'store'])->name('hotel.store');
        Route::get('hotels', [HotelController::class, 'all'])->name('hotel.all');
        Route::put('hotel/{hotel_id}', [HotelController::class, 'update'])->name('hotel.update');
        Route::delete('hotel/{hotel_id}', [HotelController::class, 'destroy'])->name('hotel.destroy');
        Route::post('hotel/{hotel_id}/rooms', [RoomController::class, 'store'])->name('hotel.rooms.store');
        Route::get('hotel/{hotel_id}/rooms/{room_id}', [RoomController::class, 'show'])->name('hotel.rooms.show');
        Route::put('hotel/{hotel_id}/rooms/{room_id}', [RoomController::class, 'update'])->name('hotel.rooms.update');
        Route::delete('hotel/{hotel_id}/rooms/{room_id}', [RoomController::class, 'destroy'])->name('hotel.rooms.destroy');
    });
    Route::middleware('role:user')->group(function () {
        Route::get('hotel/{hotel_id}/rooms', [RoomController::class, 'index'])->name('hotel.rooms.index');
        Route::post('room/{room_id}/booking', [BookingController::class, 'store'])->name('room.booking.store');
        Route::get('room/{room_id}/booking', [BookingController::class, 'index'])->name('room.booking.index');
        Route::get('booking/{booking_id}', [BookingController::class, 'show'])->name('booking.show');
        Route::put('booking/{booking_id}', [BookingController::class, 'update'])->name('booking.update');
        Route::delete('booking/{booking_id}', [BookingController::class, 'destroy'])->name('booking.destroy');
    });
});
