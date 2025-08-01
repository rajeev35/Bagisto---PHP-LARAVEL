<?php

use Illuminate\Support\Facades\Route;
use Kartwise\WishlistCompare\Http\Controllers\Admin\WishlistCompareController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin/wishlistcompare'], function () {
    Route::controller(WishlistCompareController::class)->group(function () {
        Route::get('', 'index')->name('admin.wishlistcompare.index');
    });
});