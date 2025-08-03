<?php

namespace Kartwise\WishlistCompare\Http\Controllers\Shop;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Webkul\Customer\Repositories\WishlistRepository;

class WishlistCompareController extends Controller
{
    public function counts(Request $request)
    {
        $wishlistCount = 0;
        $compareCount = 0;

        if (Auth::guard('customer')->check()) {
            $customer = Auth::guard('customer')->user();
            $wishlistRepo = app(WishlistRepository::class);

            // हर wishlist entry एक item है:
            $wishlistCount = $wishlistRepo->findWhere(['customer_id' => $customer->id])->count();
        }

        $compare = session()->get('compare', []);
        if (is_array($compare)) {
            $compareCount = count($compare);
        }

        return response()->json([
            'wishlist' => $wishlistCount,
            'compare'  => $compareCount,
        ]);
    }
}
