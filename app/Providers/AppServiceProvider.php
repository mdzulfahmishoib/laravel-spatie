<?php

namespace App\Providers;

use App\Models\gudang\permintaan_barang;
use App\Models\pengadaan\pengadaan;
use App\Models\setup_app;
use App\Models\sidebar_menu;
use App\Models\User;
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
            $users = user::all();
            $setup_app = setup_app::first();

            $view->with([
                'users' => $users,
                'setup_app' => $setup_app,
            ]);
        });

        View::composer('layouts.sidebar', function ($view) {
            $menus = sidebar_menu::whereNull('parent_id')
                ->orderBy('order')
                ->with(['children' => function ($q) {
                    $q->orderBy('order');
                }])
                ->get();

            $view->with('menus', $menus);
        });
    }


}
