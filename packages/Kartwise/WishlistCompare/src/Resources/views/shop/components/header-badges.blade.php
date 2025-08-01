@php
    $customerId = auth()->guard('customer')->check() ? auth()->guard('customer')->user()->id : null;
    $wishlistCount = $customerId ? \DB::table('kartwise_wishlist_items')->where('customer_id', $customerId)->count() : 0;
    $compareCount  = $customerId ? \DB::table('kartwise_compare_items')->where('customer_id', $customerId)->count() : 0;
@endphp

<div id="wc-header-badges" class="flex gap-4 items-center">
    <a href="{{ route('shop.customers.account.wishlist.index') }}" class="flex items-center gap-1">
        <span class="text-sm font-medium">Wishlist</span>
        <span class="ml-1 inline-flex items-center justify-center rounded-full bg-red-600 text-white text-xs px-2 py-1">
            <span v-if="false">{{ $wishlistCount }}</span>
            <span v-text="counts.wishlist">0</span>
        </span>
    </a>

    <a href="{{ route('shop.compare.index') }}" class="flex items-center gap-1">
        <span class="text-sm font-medium">Compare</span>
        <span class="ml-1 inline-flex items-center justify-center rounded-full bg-blue-600 text-white text-xs px-2 py-1">
            <span v-if="false">{{ $compareCount }}</span>
            <span v-text="counts.compare">0</span>
        </span>
    </a>
</div>

<script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
<script>
    const apiUrl = "{{ route('shop.wishlistcompare.counts') }}";

    const headerApp = Vue.createApp({
        data() {
            return {
                counts: {
                    wishlist: {{ $wishlistCount }},
                    compare: {{ $compareCount }}
                }
            };
        },
        methods: {
            async fetchCounts() {
                try {
                    const res = await fetch(apiUrl, {
                        credentials: 'same-origin',
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const data = await res.json();
                    this.counts = data;
                } catch (e) {
                    console.error(e);
                }
            }
        },
        mounted() {
            this.fetchCounts();
            this.interval = setInterval(this.fetchCounts, 30000);
            window.addEventListener('wishlistcompare-updated', this.fetchCounts);
        },
        beforeUnmount() {
            clearInterval(this.interval);
        }
    });

    window.__wc_header_app__ = headerApp.mount('#wc-header-badges');
</script>
