<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kartwise\WishlistCompare\Http\Controllers\Shop\WishlistCompareController;


Route::group(['middleware' => ['web', 'shop']], function () {

    Route::get('wishlistcompare/counts', function (Request $request) {
        $customerId = auth()->guard('customer')->check()
            ? auth()->guard('customer')->user()->id
            : $request->query('customer_id');

        $wishlistCount = 0;
        $compareCount = 0;

        if ($customerId) {
            $wishlistCount = DB::table('kartwise_wishlist_items')->where('customer_id', $customerId)->count();
            $compareCount = DB::table('kartwise_compare_items')->where('customer_id', $customerId)->count();
        }

        return response()->json([
            'wishlist' => $wishlistCount,
            'compare'  => $compareCount,
        ]);
    })->name('shop.wishlistcompare.counts');

    Route::post('wishlistcompare/wishlist/add', function (Request $request) {
        if (! auth()->guard('customer')->check()) {
            return response()->json(['message' => 'unauthenticated'], 401);
        }

        $customerId = auth()->guard('customer')->id();
        $productId = $request->input('product_id');
        if (! $productId) {
            return response()->json(['message' => 'product_id required'], 400);
        }

        DB::table('kartwise_wishlist_items')->updateOrInsert(
            ['customer_id' => $customerId, 'product_id' => $productId],
            ['updated_at' => now(), 'created_at' => now()]
        );

        return response()->json(['success' => true]);
    })->name('shop.wishlistcompare.wishlist.add');

    Route::post('wishlistcompare/wishlist/remove', function (Request $request) {
        if (! auth()->guard('customer')->check()) {
            return response()->json(['message' => 'unauthenticated'], 401);
        }

        $customerId = auth()->guard('customer')->id();
        $productId = $request->input('product_id');
        if (! $productId) {
            return response()->json(['message' => 'product_id required'], 400);
        }

        DB::table('kartwise_wishlist_items')
            ->where(['customer_id' => $customerId, 'product_id' => $productId])
            ->delete();

        return response()->json(['success' => true]);
    })->name('shop.wishlistcompare.wishlist.remove');

    Route::post('wishlistcompare/compare/add', function (Request $request) {
        if (! auth()->guard('customer')->check()) {
            return response()->json(['message' => 'unauthenticated'], 401);
        }

        $customerId = auth()->guard('customer')->id();
        $productId = $request->input('product_id');
        if (! $productId) {
            return response()->json(['message' => 'product_id required'], 400);
        }

        DB::table('kartwise_compare_items')->updateOrInsert(
            ['customer_id' => $customerId, 'product_id' => $productId],
            ['updated_at' => now(), 'created_at' => now()]
        );

        return response()->json(['success' => true]);
    })->name('shop.wishlistcompare.compare.add');

    Route::post('wishlistcompare/compare/remove', function (Request $request) {
        if (! auth()->guard('customer')->check()) {
            return response()->json(['message' => 'unauthenticated'], 401);
        }

        $customerId = auth()->guard('customer')->id();
        $productId = $request->input('product_id');
        if (! $productId) {
            return response()->json(['message' => 'product_id required'], 400);
        }

        DB::table('kartwise_compare_items')
            ->where(['customer_id' => $customerId, 'product_id' => $productId])
            ->delete();

        return response()->json(['success' => true]);
    })->name('shop.wishlistcompare.compare.remove');

    Route::get('customer/wishlist', [WishlistCompareController::class, 'wishlistPage'])
        ->name('customer.wishlist.index');

        Route::get('wishlistcompare/counts', [WishlistCompareController::class, 'counts'])
    ->name('wishlistcompare.counts');





        
});

