<?php

namespace Kartwise\WishlistCompare\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WishlistCompareController extends Controller
{
    public function wishlistPage(Request $request)
    {
        $customer = auth()->guard('customer')->user();
        if (! $customer) {
            return redirect()->route('customer.session.create'); // login if not
        }

        $productIds = DB::table('kartwise_wishlist_items')
            ->where('customer_id', $customer->id)
            ->pluck('product_id')
            ->toArray();

        $products = collect();
        if (! empty($productIds)) {
            $productRepository = app('Webkul\Product\Repositories\ProductRepository');
            $products = $productRepository->findWhereIn('id', $productIds);
        }

        return view('wishlistcompare::shop.account.wishlist.index', [
            'products' => $products,
        ]);
    }


    public function comparePage(Request $request)
    {
        $customer = auth()->guard('customer')->user();
        if (! $customer) {
            return redirect()->route('customer.session.create');
        }

        $productIds = DB::table('kartwise_compare_items')
            ->where('customer_id', $customer->id)
            ->pluck('product_id')
            ->toArray();

        $products = collect();
        if (! empty($productIds)) {
            $productRepository = app('Webkul\Product\Repositories\ProductRepository');
            $products = $productRepository->findWhereIn('id', $productIds);
        }

        return view('wishlistcompare::shop.account.compare.index', [
            'products' => $products,
        ]);
    }
}
