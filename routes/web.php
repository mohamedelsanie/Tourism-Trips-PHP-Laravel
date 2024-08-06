<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MenuController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('checksite')->namespace('App\Http\Controllers')->group(function (){
    // Home Routes
    Route::get('/', 'FrontController@index')->name('homepage');
    Route::get('/closed', 'FrontController@closed')->name('closed');
    Route::post('/sendmessage', 'FrontController@send_message')->name('sendmessage');
    // Pages Routes
    Route::get('page/{slug}', 'PagesController@page')->name('page');
    Route::post('page/{slug}/add_comment', 'PagesController@add_comment')->name('page.add_comment');
    // News Routes
    Route::get('posts', 'NewsController@index')->name('news');
    Route::get('post/{slug}', 'NewsController@post')->name('post');
    Route::post('post/{slug}/add_comment', 'NewsController@add_comment')->name('post.add_comment');
    Route::get('category/{slug}', 'NewsController@category')->name('category');
    // Images Routes
    Route::get('photos', 'ImagesController@index')->name('photos');
    Route::get('photo/{slug}', 'ImagesController@post')->name('photo');
    Route::post('photo/{slug}/add_comment', 'ImagesController@add_comment')->name('photos.add_comment');
    // Videos Routes
    Route::get('videos', 'VideosController@index')->name('videos');
    Route::get('video/{slug}', 'VideosController@post')->name('video');
    Route::post('video/{slug}/add_comment', 'VideosController@add_comment')->name('videos.add_comment');
    // News Routes
    Route::get('tours', 'ToursController@index')->name('tours');
    Route::get('tour/{slug}', 'ToursController@post')->name('tour');
    Route::post('tour/{slug}/add_comment', 'ToursController@add_comment')->name('tours.add_comment');
    Route::get('tours/category/{slug}', 'ToursController@category')->name('tours.category');
    Route::post('tours/search','ToursController@search')->name('tours.search');
    Route::get('/dashboard', 'App\Http\Controllers\FrontController@orders')->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__.'/auth.php';
});

Route::namespace('App\Http\Controllers\Admin')->prefix('admin')->name('admin.')->group(function (){
   Route::namespace('Auth')->middleware('guest:admin')->group(function (){
       Route::get('login','AuthenticatedSessionController@create')->name('login');
       Route::post('login','AuthenticatedSessionController@store')->name('adminlogin');
       Route::put('/password', 'PasswordController@update')->name('password.update');
   });
   Route::middleware('admin')->group(function(){

       Route::get('/','HomeController@base')->name('base');
       Route::get('/clear', function() {
        $exitCode = Artisan::call('config:cache');
        $exitCode = Artisan::call('config:clear');
        $exitCode = Artisan::call('cache:clear');
        $exitCode = Artisan::call('view:clear');
        $exitCode = Artisan::call('route:clear');
        $exitCode = Artisan::call('clear-compiled');
        return 'DONE'; 
      });
       // Roles Routes
       Route::resource('roles', RoleController::class);
       Route::get('roles/{id}/delete','RoleController@destroy')->name('roles.delete');
       Route::post('roles/destroy_all','RoleController@destroy_all')->name('roles.destroy_all');
       Route::post('roles/search','RoleController@search')->name('roles.search');
       // Permissions Routes
       Route::resource('permissions', PermissionsController::class);
       Route::get('permissions/{id}/delete','PermissionsController@destroy')->name('permissions.delete');
       Route::post('permissions/destroy_all','PermissionsController@destroy_all')->name('permissions.destroy_all');
       Route::post('permissions/search','PermissionsController@search')->name('permissions.search');
       // Users Routes
       Route::get('users/archive', 'UsersController@archive')->name('users.archive');
       Route::resource('users', UsersController::class);
       Route::post('users/destroy_all','UsersController@destroy_all')->name('users.destroy_all');
       Route::get('users/{id}/delete','UsersController@destroy')->name('users.delete');
       Route::post('users/restore_all','UsersController@restore_all')->name('users.restore_all');
       Route::get('users/{id}/restore','UsersController@restore')->name('users.restore');
       Route::post('users/search','UsersController@search')->name('users.search');
       // Admins Routes
       Route::get('admins/archive', 'AdminsController@archive')->name('admins.archive');
       Route::resource('admins', AdminsController::class);
       Route::post('admins/destroy_all','AdminsController@destroy_all')->name('admins.destroy_all');
       Route::get('admins/{id}/delete','AdminsController@destroy')->name('admins.delete');
       Route::post('admins/restore_all','AdminsController@restore_all')->name('admins.restore_all');
       Route::get('admins/{id}/restore','AdminsController@restore')->name('admins.restore');
       Route::post('admins/search','AdminsController@search')->name('admins.search');
       // Settings Routes
       Route::get('settings','SettingsController@form')->name('settings');
       Route::post('settings/store','SettingsController@store')->name('settings.store');
       // Media Routes
       Route::get('media/archive', 'MediaController@archive')->name('media.archive');
       Route::get('media','MediaController@index')->name('media.index');
       Route::post('media/upload','MediaController@upload')->name('media.upload');
       Route::get('media/{id}/show','MediaController@show')->name('media.show');
       Route::get('media/{id}/edit','MediaController@edit')->name('media.edit');
       Route::put('media/{id}/update','MediaController@update')->name('media.update');
       Route::post('media/destroy_all','MediaController@destroy_all')->name('media.destroy_all');
       Route::get('media/{id}/delete','MediaController@destroy')->name('media.delete');
       Route::post('media/restore_all','MediaController@restore_all')->name('media.restore_all');
       Route::get('media/{id}/restore','MediaController@restore')->name('media.restore');
       Route::post('media/search','MediaController@search')->name('media.search');
       // Pages Routes
       Route::get('pages/archive', 'PagesController@archive')->name('pages.archive');
       Route::resource('pages', PagesController::class);
       Route::post('pages/destroy_all','PagesController@destroy_all')->name('pages.destroy_all');
       Route::get('pages/{id}/delete','PagesController@destroy')->name('pages.delete');
       Route::post('pages/restore_all','PagesController@restore_all')->name('pages.restore_all');
       Route::get('pages/{id}/restore','PagesController@restore')->name('pages.restore');
       Route::post('pages/search','PagesController@search')->name('pages.search');
       // Images Comments Routes
       Route::get('page/comments/archive', 'PagesCommentsController@archive')->name('page.comments.archive');
       Route::resource('page/comments', PagesCommentsController::class,['as' => 'page']);
       Route::post('page/comments/destroy_all','PagesCommentsController@destroy_all')->name('page.comments.destroy_all');
       Route::get('page/comments/{id}/delete','PagesCommentsController@destroy')->name('page.comments.delete');
       Route::post('page/comments/restore_all','PagesCommentsController@restore_all')->name('page.comments.restore_all');
       Route::get('page/comments/{id}/restore','PagesCommentsController@restore')->name('page.comments.restore');
       Route::post('page/comments/search','PagesCommentsController@search')->name('page.comments.search');

       // Offers Routes
       Route::get('offers/archive', 'OffersController@archive')->name('offers.archive');
       Route::resource('offers', OffersController::class);
       Route::post('offers/destroy_all','OffersController@destroy_all')->name('offers.destroy_all');
       Route::get('offers/{id}/delete','OffersController@destroy')->name('offers.delete');
       Route::post('offers/restore_all','OffersController@restore_all')->name('offers.restore_all');
       Route::get('offers/{id}/restore','OffersController@restore')->name('offers.restore');
       Route::post('offers/search','OffersController@search')->name('offers.search');
       // Tours Routes
       Route::get('tours/archive', 'ToursController@archive')->name('tours.archive');
       Route::resource('tours', ToursController::class);
       Route::post('tours/destroy_all','ToursController@destroy_all')->name('tours.destroy_all');
       Route::get('tours/{id}/delete','ToursController@destroy')->name('tours.delete');
       Route::post('tours/restore_all','ToursController@restore_all')->name('tours.restore_all');
       Route::get('tours/{id}/restore','ToursController@restore')->name('tours.restore');
       Route::post('tours/search','ToursController@search')->name('tours.search');
       // Tours Categories Routes
       Route::get('tour/categories/archive', 'ToursCategoriesController@archive')->name('tour.categories.archive');
       Route::resource('tour/categories', ToursCategoriesController::class,['as' => 'tour']);
       Route::post('tour/categories/destroy_all','ToursCategoriesController@destroy_all')->name('tour.categories.destroy_all');
       Route::get('tour/categories/{id}/delete','ToursCategoriesController@destroy')->name('tour.categories.delete');
       Route::post('tour/categories/restore_all','ToursCategoriesController@restore_all')->name('tour.categories.restore_all');
       Route::get('tour/categories/{id}/restore','ToursCategoriesController@restore')->name('tour.categories.restore');
       Route::post('tour/categories/search','ToursCategoriesController@search')->name('tour.categories.search');
       // Tours Comments Routes
       Route::get('tour/comments/archive', 'ToursCommentsController@archive')->name('tour.comments.archive');
       Route::resource('tour/comments', ToursCommentsController::class,['as' => 'tour']);
       Route::post('tour/comments/destroy_all','ToursCommentsController@destroy_all')->name('tour.comments.destroy_all');
       Route::get('tour/comments/{id}/delete','ToursCommentsController@destroy')->name('tour.comments.delete');
       Route::post('tour/comments/restore_all','ToursCommentsController@restore_all')->name('tour.comments.restore_all');
       Route::get('tour/comments/{id}/restore','ToursCommentsController@restore')->name('tour.comments.restore');
       Route::post('tour/comments/search','ToursCommentsController@search')->name('tour.comments.search');

       // Orders Comments Routes
       Route::get('orders/archive', 'OrdersController@archive')->name('orders.archive');
       Route::resource('orders', OrdersController::class);
       Route::post('orders/destroy_all','OrdersController@destroy_all')->name('orders.destroy_all');
       Route::get('orders/{id}/delete','OrdersController@destroy')->name('orders.delete');
       Route::post('orders/restore_all','OrdersController@restore_all')->name('orders.restore_all');
       Route::get('orders/{id}/restore','OrdersController@restore')->name('orders.restore');
       Route::post('orders/search','OrdersController@search')->name('orders.search');

       // Contacts Comments Routes
       Route::get('contacts/archive', 'ContactsController@archive')->name('contacts.archive');
       Route::resource('contacts', ContactsController::class);
       Route::post('contacts/destroy_all','ContactsController@destroy_all')->name('contacts.destroy_all');
       Route::get('contacts/{id}/delete','ContactsController@destroy')->name('contacts.delete');
       Route::post('contacts/restore_all','ContactsController@restore_all')->name('contacts.restore_all');
       Route::get('contacts/{id}/restore','ContactsController@restore')->name('contacts.restore');
       Route::post('contacts/search','ContactsController@search')->name('contacts.search');

       // Videos Routes
       Route::get('videos/archive', 'VideosController@archive')->name('videos.archive');
       Route::resource('videos', VideosController::class);
       Route::post('videos/destroy_all','VideosController@destroy_all')->name('videos.destroy_all');
       Route::get('videos/{id}/delete','VideosController@destroy')->name('videos.delete');
       Route::post('videos/restore_all','VideosController@restore_all')->name('videos.restore_all');
       Route::get('videos/{id}/restore','VideosController@restore')->name('videos.restore');
       Route::post('videos/search','VideosController@search')->name('videos.search');
       // Videos Comments Routes
       Route::get('video/comments/archive', 'VideosCommentsController@archive')->name('video.comments.archive');
       Route::resource('video/comments', VideosCommentsController::class,['as' => 'video']);
       Route::post('video/comments/destroy_all','VideosCommentsController@destroy_all')->name('video.comments.destroy_all');
       Route::get('video/comments/{id}/delete','VideosCommentsController@destroy')->name('video.comments.delete');
       Route::post('video/comments/restore_all','VideosCommentsController@restore_all')->name('video.comments.restore_all');
       Route::get('video/comments/{id}/restore','VideosCommentsController@restore')->name('video.comments.restore');
       Route::post('video/comments/search','VideosCommentsController@search')->name('video.comments.search');
       // Images Routes
       Route::get('images/archive', 'ImagesController@archive')->name('images.archive');
       Route::resource('images', ImagesController::class);
       Route::post('images/destroy_all','ImagesController@destroy_all')->name('images.destroy_all');
       Route::get('images/{id}/delete','ImagesController@destroy')->name('images.delete');
       Route::post('images/restore_all','ImagesController@restore_all')->name('images.restore_all');
       Route::get('images/{id}/restore','ImagesController@restore')->name('images.restore');
       Route::post('images/search','ImagesController@search')->name('images.search');
       // Images Comments Routes
       Route::get('image/comments/archive', 'ImagesCommentsController@archive')->name('image.comments.archive');
       Route::resource('image/comments', ImagesCommentsController::class,['as' => 'image']);
       Route::post('image/comments/destroy_all','ImagesCommentsController@destroy_all')->name('image.comments.destroy_all');
       Route::get('image/comments/{id}/delete','ImagesCommentsController@destroy')->name('image.comments.delete');
       Route::post('image/comments/restore_all','ImagesCommentsController@restore_all')->name('image.comments.restore_all');
       Route::get('image/comments/{id}/restore','ImagesCommentsController@restore')->name('image.comments.restore');
       Route::post('image/comments/search','ImagesCommentsController@search')->name('image.comments.search');
       // Menu Routes
       Route::get('menus/{id?}',[MenuController::class,'index'])->name('menus.index'); //{id?}
       Route::post('menus/create',[MenuController::class,'store'])->name('menus.store');
       Route::get('menus/add/categories',[MenuController::class,'addCatToMenu'])->name('menus.addCatToMenu');
       Route::get('menus/add/tours-categories',[MenuController::class,'addToursCatToMenu'])->name('menus.addToursCatToMenu');
       Route::get('menus/add/post',[MenuController::class,'addPostToMenu'])->name('menus.addPostToMenu');
       Route::get('menus/add/tour',[MenuController::class,'addTourToMenu'])->name('menus.addTourToMenu');
       Route::get('menus/add/link','MenuController@addCustomLink')->name('menus.addCustomLink');
       Route::get('menus/update/update-menu',[MenuController::class,'updateMenu'])->name('menus.updateMenu');
       Route::post('menus/update-menuitem/{id}',[MenuController::class,'updateMenuItem'])->name('menus.updateMenuItem');
       Route::get('menus/delete-menuitem/{id}/{key}/{in?}',[MenuController::class,'deleteMenuItem'])->name('menus.deleteMenuItem');
       Route::get('menus/delete-menu/{id}',[MenuController::class,'destroy'])->name('menus.destroy');
       // News Categories Routes
       Route::get('categories/archive', 'NewsCategoriesController@archive')->name('categories.archive');
       Route::resource('categories', NewsCategoriesController::class);
       Route::post('categories/destroy_all','NewsCategoriesController@destroy_all')->name('categories.destroy_all');
       Route::get('categories/{id}/delete','NewsCategoriesController@destroy')->name('categories.delete');
       Route::post('categories/restore_all','NewsCategoriesController@restore_all')->name('categories.restore_all');
       Route::get('categories/{id}/restore','NewsCategoriesController@restore')->name('categories.restore');
       Route::post('categories/search','NewsCategoriesController@search')->name('categories.search');
       // Posts Routes
       Route::get('posts/archive', 'NewsController@archive')->name('posts.archive');
       Route::resource('posts', NewsController::class);
       Route::post('posts/destroy_all','NewsController@destroy_all')->name('posts.destroy_all');
       Route::get('posts/{id}/delete','NewsController@destroy')->name('posts.delete');
       Route::post('posts/restore_all','NewsController@restore_all')->name('posts.restore_all');
       Route::get('posts/{id}/restore','NewsController@restore')->name('posts.restore');
       Route::post('posts/search','NewsController@search')->name('posts.search');
       // Comments Routes
       Route::get('comments/archive', 'NewsCommentsController@archive')->name('comments.archive');
       Route::resource('comments', NewsCommentsController::class);
       Route::post('comments/destroy_all','NewsCommentsController@destroy_all')->name('comments.destroy_all');
       Route::get('comments/{id}/delete','NewsCommentsController@destroy')->name('comments.delete');
       Route::post('comments/restore_all','NewsCommentsController@restore_all')->name('comments.restore_all');
       Route::get('comments/{id}/restore','NewsCommentsController@restore')->name('comments.restore');
       Route::post('comments/search','NewsCommentsController@search')->name('comments.search');
       // Tags Routes
       Route::resource('tags', NewsTagsController::class);
       Route::get('tags/{id}/delete','NewsTagsController@destroy')->name('tags.delete');
       Route::post('tags/destroy_all','NewsTagsController@destroy_all')->name('tags.destroy_all');
       Route::post('tags/search','NewsTagsController@search')->name('tags.search');
       // Dashboard Routes
       Route::get('/dashboard','HomeController@index')->name('dashboard');
       Route::get('/profile', 'ProfileController@edit')->name('profile.edit');
       Route::patch('/profile', 'ProfileController@update')->name('profile.update');
       Route::delete('/profile', 'ProfileController@destroy')->name('profile.destroy');
       Route::get('sidebar','HomeController@sidebar')->name('sidebar');



   });
    Route::post('logout','Auth\AuthenticatedSessionController@destroy')->name('logout');
});
