@php
    $customer = auth()->guard('customer')->user();
    $wishlistCount = 0;
    if ($customer && $customer->wishlist) {
        $wishlistCount = $customer->wishlist->items()->count();
    }
@endphp

<div class="mb-6">
    <h1 class="text-lg font-semibold">
        Wishlist ({{ $wishlistCount }} item{{ $wishlistCount === 1 ? '' : 's' }})
    </h1>
</div>
