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
    // Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    // Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
    // Route::post('/role/store', [RoleController::class, 'store'])->name('role.store');
    // Route::get('/role/{id}/update', [RoleController::class, 'update'])->name('role.update');
    // Route::post('/role/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
    // Route::get('/role/{id}/permissions', [RoleController::class, 'manage'])->name('role.manage');
    // Route::get('/role/role-datatable/list', [RoleController::class, 'getDatatableIndex'])->name('role.datatable');


    Route::resourceRoutes('role', RoleController::class, function ($controller) {
        Route::post('/role/update/{id}', [RoleController::class, 'update'])->name('role.update');
        Route::get('/role-datatable/list', [RoleController::class, 'getDatatableIndex'])->name('role.datatable');
        Route::get('/role-trash-datatable/list', [RoleController::class, 'getDatatableTrash'])->name('role.trash-datatable');
        Route::get('/role/{id}/permissions', [RoleController::class, 'manage'])->name('role.manage');
        Route::post('/role/{role}/permissions', [RoleController::class, 'update_permissions'])->name('role.update_permissions');
    });

    // Route::resource('category', CategoryController::class);
    Route::resourceRoutes('category', CategoryController::class, function ($controller) {
        Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::get('/category-datatable/list', [CategoryController::class, 'getDatatableIndex'])->name('category.datatable');
        Route::get('/category-trash-datatable/list', [CategoryController::class, 'getDatatableTrash'])->name('category.trash-datatable');
    });

    Route::resourceRoutes('post', PostController::class, function ($controller) {
        Route::post('/post/update/{id}', [PostController::class, 'update'])->name('post.update');
        Route::get('/post-datatable/list', [PostController::class, 'getDatatableIndex'])->name('post.datatable');
        Route::get('/post-trash-datatable/list', [PostController::class, 'getDatatableTrash'])->name('post.trash-datatable');
    });

    Route::resourceRoutes('item', ItemController::class, function ($controller) {
        Route::post('/item/update/{id}', [ItemController::class, 'update'])->name('item.update');
        Route::get('/item-datatable/list', [ItemController::class, 'getDatatableIndex'])->name('item.datatable');
        Route::get('/item-trash-datatable/list', [ItemController::class, 'getDatatableTrash'])->name('item.trash-datatable');
    });

    Route::resourceRoutes('user', UserController::class, function ($controller) {
        Route::post('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::get('/user-datatable/list', [UserController::class, 'getDatatableIndex'])->name('user.datatable');
        Route::get('/user-trash-datatable/list', [UserController::class, 'getDatatableTrash'])->name('user.trash-datatable');
    });


    // Ajax
    $ajaxGets = [
        'getOptions',
        'get_category_select',
    ];

    foreach ($ajaxGets as $ajaxGet) {
        Route::get('ajax/' . $ajaxGet . '/{id?}', [AjaxController::class, $ajaxGet])->name('ajax.' . $ajaxGet);
    }

    Route::post('ajax/verifyRules/{id?}', [AjaxController::class, 'verifyRules'])->name('ajax.verifyRules');

});
