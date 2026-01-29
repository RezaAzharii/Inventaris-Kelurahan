<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('*', function ($view) {
            $user = Auth::user();
            $menuItems = [
                [
                    'label' => 'Dashboard',
                    'icon' => 'bi bi-house',
                    'route' => 'dashboard',
                ],
                [
                    'label' => 'Aset',
                    'icon' => 'bi bi-box',
                    'route' => 'aset.index',
                ],
                [
                    'label' => 'Data Peminjaman',
                    'icon' => 'bi bi-archive',
                    'route' => 'peminjaman.index',
                ]
            ];
            if ($user && $user->role === 'isAdmin') {
                $menuItems[] = [
                    'label' => 'Peminjam',
                    'icon'  => 'bi bi-people',
                    'route' => 'peminjam.index',
                ];
            }

            $view->with('menuItems', $menuItems);
        });
    }
}