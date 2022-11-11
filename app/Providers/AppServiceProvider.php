<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();

        //global variable
        // if(Session::get('login')){
            
        //     $cart = Cart::where('user_id', auth()->user()->id);
        //     $cartTotal = $cart->count();
        //     Session::put('cartTotal',$cartTotal);
    
        //     View::share($cartTotal);
        // }
    }
}
