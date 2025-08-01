@php
    $customerId = auth()->guard('customer')->check() ? auth()->guard('customer')->user()->id : null;
    $count = $customerId ? \DB::table('kartwise_compare_items')->where('customer_id', $customerId)->count() : 0;
@endphp

<!-- <div class="mb-4">
    <strong>Compare Items:</strong> {{ $count }}
</div> -->


<span
    v-if="! isLoading"
    class="ml-3 inline-flex items-center px-4 py-1 rounded-full shadow whitespace-nowrap flex-shrink-0"
    style="background:#fde68a; border:2px solid #4f46e5; color:#1f2937;"
>
    @{{ items.length }} Items
</span>
