<?php

namespace Kartwise\WishlistCompare\Http\Controllers\Shop;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Webkul\Customer\Repositories\WishlistRepository;
use Webkul\Customer\Repositories\CompareItemRepository;

class WishlistCompareController extends Controller
{
    public function counts(Request $request)
    {
        $wishlistCount = 0;
        $compareCount = 0;

        $customer = auth()->guard('customer')->user();

        if ($customer) {
            
            $wishlistRepo = app(WishlistRepository::class);
            $compareRepo = app(CompareItemRepository::class);

            $wishlistCount = $wishlistRepo->findByField('customer_id', $customer->id)->count();
            $compareCount = $compareRepo->findByField('customer_id', $customer->id)->count();
        } else {
           
            $sessionWishlist = session('wishlist', []);
            $wishlistCount = is_array($sessionWishlist) ? count($sessionWishlist) : 0;

            
            if ($request->filled('compare_items')) {
                $items = json_decode($request->get('compare_items'), true);
                $compareCount = is_array($items) ? count($items) : 0;
            } else {
                $sessionCompare = session('compare_items', []);
                $compareCount = is_array($sessionCompare) ? count($sessionCompare) : 0;
            }
        }

        return response()->json([
            'wishlist' => $wishlistCount,
            'compare'  => $compareCount,
        ]);
    }
}
