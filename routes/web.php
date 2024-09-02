<?php

use App\Http\Controllers\Dashboard\AjaxController\AjaxController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ItemController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        // return view('dashboard');
        return view('dashboard');
    })->name('dashboard');
});


Route::get('locale/{locale}', function ($locale) {
    App::setLocale($locale);
    Cookie::queue('dynacore_locale', $locale, 15768000); // 6 monthes
    // Cookie::queue('accordion_status', 'opened', 15768000); // 6 monthes
    return redirect()->back();
})->name('set-locale');

Route::name('dashboard.')->prefix('/dashboard')->middleware(['auth'])->group(function () {
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');


    Route::resourceRoutes('role', RoleController::class, function ($controller) {
        Route::get('/role/{id}/permissions', [RoleController::class, 'manage'])->name('role.manage');
        Route::post('/role/{role}/permissions', [RoleController::class, 'update_permissions'])->name('role.update_permissions');
    });







    // Route::resource('category', CategoryController::class);
    Route::resourceRoutes('category', CategoryController::class);

    Route::resourceRoutes('post', PostController::class);

    Route::resourceRoutes('item', ItemController::class);

    Route::resourceRoutes('user', UserController::class);


    // Ajax
    $ajaxGets = [
        'getOptions' => 'get',
        'get_category_select' => 'get',
        'verifyRules' => 'post',
    ];

    foreach ($ajaxGets as $ajaxGet => $method) {
        if ($method == 'get') {
            Route::get('ajax/' . $ajaxGet . '/{id?}', [AjaxController::class, $ajaxGet])->name('ajax.' . $ajaxGet);
        } else {
            Route::post('ajax/' . $ajaxGet . '/{id?}', [AjaxController::class, $ajaxGet])->name('ajax.' . $ajaxGet);
        }
    }

});
