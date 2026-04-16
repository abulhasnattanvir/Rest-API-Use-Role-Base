<?php

namespace App\Providers;

use App\Models\Booking;
use App\Policies\BookingPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // Gate::policy(Booking::class, BookingPolicy::class);

        RateLimiter::for('custom-booking-limit',function($request){
            $user = $request->user();
            if($user && $user->role === 'super admin'){
                //admins get more capacity
                return Limit::none();
            }
            if($user && $user->role === 'admin'){
                //admins get more capacity
                return Limit::perMinute(10)->by($user->id);
            }
            // RateLimiter::increment('custom-booking-limit:'.$user->id);
            //guests or normal users get fewer requests

            return Limit::perMinute(5)->by(optional($user)->id ?: $request->ip());
        });
    }
}