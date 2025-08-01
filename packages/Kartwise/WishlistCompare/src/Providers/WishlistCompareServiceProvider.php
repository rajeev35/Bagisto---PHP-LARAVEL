<?php

namespace Kartwise\WishlistCompare\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class WishlistCompareServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/shop-routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'wishlistcompare');

        // === HEADER BADGES ===
        Event::listen('bagisto.shop.components.layouts.header.desktop.bottom.before', function ($manager) {
            $manager->addTemplate('wishlistcompare::shop.components.header-badges');
        });
        Event::listen('bagisto.shop.components.layouts.header.mobile.bottom.before', function ($manager) {
            $manager->addTemplate('wishlistcompare::shop.components.header-badges');
        });

        // === WISHLIST PAGE COUNTER ===
        // Blade mein event hai: bagisto.shop.customers.account.wishlist.list.before
        // Event::listen('bagisto.shop.customers.account.wishlist.list.before', function ($manager) {
        //     \Log::info('✅ Wishlist Event fired');
        //     $manager->addTemplate('wishlistcompare::shop.components.wishlist-counter');
        // });

        // === COMPARE PAGE COUNTER ===
        // Blade mein event hai: bagisto.shop.customers.account.compare.before
        Event::listen('bagisto.shop.customers.account.compare.before', function ($manager) {
            $manager->addTemplate('wishlistcompare::shop.components.compare-counter');
        });
    }

    public function register()
    {
        //
    }
}
