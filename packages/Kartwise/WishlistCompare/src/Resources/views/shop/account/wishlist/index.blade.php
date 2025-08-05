@extends('shop::layouts.account')

@section('page_title')
    Wishlist
@endsection

@section('content')
    <div class="wishlist-wrapper">
        {!! view_render_event('bagisto.shop.customers.account.wishlist.list.before') !!}

        @if(isset($products) && $products->count())
            <div class="grid grid-cols-1 gap-4">
                @foreach($products as $product)
                    <div class="border p-4 rounded">
                        <a href="{{ route('shop.productOrCategory.index', $product->url_key) }}">
                            <h2 class="font-semibold">{{ $product->name }}</h2>
                        </a>
                        <p>Price: {{ core()->currency($product->price) }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p>Your wishlist is empty.</p>
        @endif

        {!! view_render_event('bagisto.shop.customers.account.wishlist.list.after') !!}
    </div>
@endsection
