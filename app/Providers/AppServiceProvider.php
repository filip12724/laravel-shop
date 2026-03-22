<?php

namespace App\Providers;

use App\Models\ActivityLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::share('mainNavLinks', [
            ['label' => 'Home',    'route' => 'home',       'icon' => 'fa-home',     'active' => ['home']],
            ['label' => 'Shop',    'route' => 'shop.index',  'icon' => 'fa-store',    'active' => ['shop.index', 'shop.show']],
            ['label' => 'Contact', 'route' => 'contact',     'icon' => 'fa-envelope', 'active' => ['contact']],
        ]);

        Event::listen(Registered::class, function (Registered $event) {
            ActivityLog::log('user_registered', "New user registered: '{$event->user->name}' ({$event->user->email})", $event->user->id);
        });

        Event::listen(Login::class, function (Login $event) {
            ActivityLog::log('user_login', "User '{$event->user->name}' logged in", $event->user->id);
        });

        Event::listen(Logout::class, function (Logout $event) {
            if ($event->user) {
                ActivityLog::log('user_logout', "User '{$event->user->name}' logged out", $event->user->id);
            }
        });
    }
}
