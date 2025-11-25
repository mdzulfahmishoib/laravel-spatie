<?php

use App\Http\Controllers\Layouts\BerandaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

//Management User
use App\Http\Controllers\Management_user\PermissionController;
use App\Http\Controllers\Management_user\RoleController;
use App\Http\Controllers\Management_user\UserController;
use App\Http\Controllers\setup_appController;
use App\Http\Controllers\sidebar_menuController;

Route::group(['middleware' => 'auth'], function() {   

    Route::group([], function () { //Management User
        Route::resource('management_user/permission', PermissionController::class);
        Route::get('permission/{permissionId}/delete', [PermissionController::class, 'destroy']);
        
        Route::resource('management_user/roles', RoleController::class);
        Route::get('roles/{roleId}/delete', [RoleController::class, 'destroy']);
        Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole']);
        Route::put('roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole']);
        
        Route::resource('management_user/users', UserController::class);
        Route::get('users/{userId}/delete', [UserController::class, 'destroy']);
        Route::patch('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
        
        Route::put('management_user/profil', [UserController::class, 'updateProfile'])->name('profil.update');
        Route::get('management_user/profil', [UserController::class, 'userProfile'])->name('layouts.profil');
    }); 

    Route::group([], function () { //Setup App
        Route::put('/setup_app', [setup_appController::class, 'update'])->name('setup_app.update');
        Route::get('/setup_app', [setup_appController::class, 'index'])->name('setup_app.index');
    });

    Route::group([], function () { //Sidebar Menu
        Route::delete('sidebar_menu/{id}', [sidebar_menuController::class, 'destroy'])->name('sidebar_menu.destroy');
        Route::get('sidebar_menu/{id}/edit', [sidebar_menuController::class, 'edit'])->name('sidebar_menu.edit');
        Route::put('sidebar_menu/{id}', [sidebar_menuController::class, 'update'])->name('sidebar_menu.update');

        Route::get('sidebar_menu', [sidebar_menuController::class, 'index'])->name('sidebar_menu.index');
        Route::post('sidebar_menu', [sidebar_menuController::class, 'store'])->name('sidebar_menu.store');
        Route::post('sidebar_menu/order', [sidebar_menuController::class, 'reorder'])->name('sidebar_menu.reorder');
    });

    Route::resource('beranda', BerandaController::class);
    Route::get('/beranda', [BerandaController::class, 'index']) -> name('beranda');

    Route::middleware(['auth'])->group(function () {
        Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
    });

    Route::get('/informasi/panduan_pemakaian', function() {
        return view('informasi.panduan.index');
    });

    });


Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('beranda');
    }
    return redirect()->route('login');
});

require __DIR__.'/auth.php';