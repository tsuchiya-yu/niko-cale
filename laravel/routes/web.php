<?php

use App\Http\Controllers\Api\CalendarController as ApiCalendarController;
use App\Http\Controllers\Api\MemberConditionController;
use App\Http\Controllers\CalendarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('top');
})->name('top');

Route::prefix('calendars')->group(function () {
    Route::get('/', [CalendarController::class, 'create'])->name('calendars.create');
    Route::post('/', [CalendarController::class, 'store'])->name('calendars.store');
    Route::get('/stored/{uuid}', [CalendarController::class, 'stored'])->name('calendars.stored');
    Route::get('/{uuid}', [CalendarController::class, 'show'])->name('calendars.show');
    Route::get('/{uuid}/edit', [CalendarController::class, 'edit'])->name('calendars.edit');
    Route::put('/{uuid}', [CalendarController::class, 'update'])->name('calendars.update');
});

Route::prefix('api')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::prefix('member-condition')->group(function () {
            Route::post('/update', [MemberConditionController::class, 'update'])->name('api.v1.member-condition.update');
            Route::delete('/', [MemberConditionController::class, 'destroy'])->name('api.v1.member-condition.destroy');
        });
        Route::prefix('calendars')->group(function () {
            Route::prefix('{uuid}')->group(function () {
                Route::delete('/', [ApiCalendarController::class, 'destroy'])->name('api.v1.calendars.destroy');
            });
        });
    });
});

// 静的ページのルーティング
Route::get('/terms', function () {
    return view('terms');
})->name('terms');
Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');
